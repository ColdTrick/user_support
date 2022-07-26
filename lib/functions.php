<?php
/**
 * All helper functions are bundled here
 */

use Elgg\Database\QueryBuilder;
use Elgg\Exceptions\Http\GatekeeperException;

/**
 * Get the context for a page, for the help system
 *
 * @param string $url the (optional) url to get the context for
 *
 * @return false|string
 */
function user_support_get_help_context(string $url = '') {
	
	if (empty($url)) {
		$url = elgg_get_current_url();
	}
	
	if (empty($url)) {
		return false;
	}
	
	$path = rtrim(parse_url($url, PHP_URL_PATH), '/');
	if (empty($path)) {
		return '_index';
	}
	
	$parts = explode('/', $path);
	
	$page_owner = elgg_get_page_owner_entity();
	if (empty($page_owner)) {
		$page_owner = elgg_get_logged_in_user_entity();
	}
	
	$new_parts = [];
	
	foreach ($parts as $part) {
		if (empty($part)) {
			continue;
		}
		
		if (is_numeric($part) || (!empty($page_owner) && ($page_owner->username === $part))) {
			break;
		}
		
		$new_parts[] = $part;
	}
	
	if (empty($new_parts)) {
		return false;
	}
	
	return implode('/', $new_parts);
}

/**
 * Get all the admins that need a notification about a ticket
 *
 * @param UserSupportTicket $ticket the ticket to get the admins for
 *
 * @return ElggUser[]
 */
function user_support_get_admin_notify_users(UserSupportTicket $ticket): array {
	
	$users = elgg_get_entities([
		'type' => 'user',
		'limit' => false,
		'wheres' => [
			function (QueryBuilder $qb, $main_alias) use ($ticket) {
				return $qb->compare("{$main_alias}.guid", '!=', $ticket->owner_guid, ELGG_VALUE_GUID);
			},
		],
		'metadata_name_value_pairs' => [
			[
				'name' => 'admin',
				'value' => 'yes',
			],
			[
				'name' => 'support_staff',
				'value' => 0,
				'operand' => '>=',
				'as' => 'integer',
			],
		],
		'metadata_name_value_pairs_operator' => 'OR',
	]);
	
	// trigger hook to get more/less users
	$params = [
		'users' => $users,
		'entity' => $ticket,
	];
	$users = elgg_trigger_plugin_hook('admin_notify', 'user_support', $params, $users);
	if (empty($users)) {
		return [];
	}
	
	if (!is_array($users)) {
		$users = [$users];
	}
	
	return $users;
}

/**
 * Added gatekeeper function for support staff
 *
 * @param bool $forward   forward the user to REFERER
 * @param int  $user_guid the user to check (default: current user)
 *
 * @return bool
 */
function user_support_staff_gatekeeper(bool $forward = true, int $user_guid = 0): bool {
	static $staff_cache;
	
	$result = false;
	
	if (empty($user_guid)) {
		$user_guid = elgg_get_logged_in_user_guid();
	}
	
	if (!empty($user_guid)) {
		if (!isset($staff_cache)) {
			$staff_cache = [];
			
			$options = [
				'type' => 'user',
				'limit' => false,
				'metadata_name' => 'support_staff',
				'callback' => function ($row) {
					return (int) $row->guid;
				},
			];
			
			$options = elgg_trigger_plugin_hook('staff_gatekeeper:options', 'user_support', $options, $options);
			if (!empty($options) && is_array($options)) {
				$staff_cache = elgg_get_entities($options);
			}
		}
		
		if (in_array($user_guid, $staff_cache)) {
			$result = true;
		} else {
			$user = get_user($user_guid);
			if (!empty($user) && $user->isAdmin()) {
				$result = true;
			}
		}
	}
	
	if (!$result && $forward) {
		throw new GatekeeperException(elgg_echo('user_support:staff_gatekeeper'));
	}
	
	return $result;
}

/**
 * Prepare the form values for an FAQ
 *
 * @param array $params params to prefill parts of the form
 * 	- entity 			UserSupportFAQ when editing an FAQ
 * 	- comment_guid 		for promoting a comment on a support ticket to a FAQ
 * 	- url				to fill the help context (default: current URL)
 * 	- container_guid	the container where the FAQ will be created (default: page_owner_guid)
 *
 * @return array
 */
function user_support_prepare_faq_form_vars(array $params = []): array {
	
	// defaults
	$result = [
		'title' => '',
		'description' => '',
		'tags' => [],
		'help_context' => user_support_get_help_context(elgg_extract('url', $params, '')),
		'access_id' => elgg_get_default_access(null, [
			'entity_type' => 'object',
			'entity_subtype' => UserSupportFAQ::SUBTYPE,
			'container_guid' => elgg_extract('container_guid', $params, elgg_get_page_owner_guid()),
		]),
		'allow_comments' => 'no',
		'container_guid' => elgg_extract('container_guid', $params, elgg_get_page_owner_guid()),
	];
	
	// check for comment promotion
	$comment_guid = (int) elgg_extract('comment_guid', $params);
	if (!empty($comment_guid)) {
		$comment = get_entity($comment_guid);
		if ($comment instanceof ElggComment) {
			$support = $comment->getContainerEntity();
			if ($support instanceof UserSupportTicket) {
				$result['title'] = $support->getDisplayName();
				$result['description'] = $comment->description;
				$result['tags'] = $support->tags;
				$result['help_context'] = $support->help_context;
				
				$result['comment'] = $comment;
			}
		}
	}
	
	// edit FAQ
	$entity = elgg_extract('entity', $params);
	if ($entity instanceof UserSupportFAQ) {
		foreach ($result as $key => $value) {
			$result[$key] = $entity->$key;
		}
		
		$result['entity'] = $entity;
	}
	
	// sticky form
	$sticky_form = elgg_get_sticky_values('user_support_faq');
	if (!empty($sticky_form)) {
		foreach ($sticky_form as $key => $value) {
			$result[$key] = $value;
		}
		
		elgg_clear_sticky_form('user_support_faq');
	}
	
	return $result;
}

/**
 * Prepare form vars for create/edit support ticket
 *
 * @param array $params params to prefill parts of the form
 * 	- entity 			UserSupportTicket when editing an ticket
 * 	- url				to fill the help context (default: current URL)
 *
 * @return array
 */
function user_support_prepare_ticket_form_vars(array $params = []): array {
	
	// defaults
	$result = [
		'description' => '',
		'tags' => [],
		'help_url' => elgg_extract('help_url', $params, ''),
		'support_type' => '',
		'help_context' => user_support_get_help_context(elgg_extract('help_url', $params, '')),
	];
		
	// edit ticket
	$entity = elgg_extract('entity', $params);
	if ($entity instanceof UserSupportTicket) {
		foreach ($result as $key => $value) {
			$result[$key] = $entity->$key;
		}
		
		$result['entity'] = $entity;
	}
	
	// sticky form
	$sticky_form = elgg_get_sticky_values('user_support_ticket');
	if (!empty($sticky_form)) {
		foreach ($sticky_form as $key => $value) {
			$result[$key] = $value;
		}
		
		elgg_clear_sticky_form('user_support_ticket');
	}
	
	return $result;
}

/**
 * Prepare form vars for create/edit a contextual help
 *
 * @param array $params params to prefill parts of the form
 * 	- entity 			UserSupportHelp when editing an help
 * 	- url				to fill the help context (default: current URL)
 *
 * @return array
 */
function user_support_prepare_help_form_vars(array $params = []): array {
	
	// defaults
	$result = [
		'description' => '',
		'tags' => [],
		'help_context' => user_support_get_help_context(elgg_extract('url', $params, '')),
	];
	
	// edit help
	$entity = elgg_extract('entity', $params);
	if ($entity instanceof UserSupportHelp) {
		foreach ($result as $key => $value) {
			$result[$key] = $entity->$key;
		}
		
		$result['entity'] = $entity;
	}
	
	return $result;
}

/**
 * Get an ACL to use for storing Support tickets so only the user can access them.
 * The ACL will be created if not already present
 *
 * @param int $user_guid the GUID of the user to get the ACL for (default: current user)
 *
 * @return false|int
 */
function user_support_get_support_ticket_acl(int $user_guid = 0) {
	static $cache = [];
	
	if ($user_guid < 1) {
		$user_guid = elgg_get_logged_in_user_guid();
	}
	
	if (empty($user_guid)) {
		return false;
	}
	
	if (isset($cache[$user_guid])) {
		return $cache[$user_guid];
	}
	
	$user = get_user($user_guid);
	if (!$user instanceof \ElggUser) {
		return false;
	}
	
	// check if ACL is present
	$acl_id = (int) elgg_get_plugin_user_setting('support_ticket_acl', $user_guid, 'user_support');
	if (!empty($acl_id)) {
		$cache[$user_guid] = $acl_id;
		return $cache[$user_guid];
	}
	
	$plugin = elgg_get_plugin_from_id('user_support');
	
	// create acl this user
	$acl_id = elgg_create_access_collection("support_ticket_acl_{$user_guid}", $plugin->guid, 'support_ticket');
	if (empty($acl_id)) {
		return false;
	}
	
	$acl = elgg_get_access_collection($acl_id);
	if (!$acl instanceof \ElggAccessCollection) {
		return false;
	}
	
	// add user to acl
	if (!$acl->addMember($user_guid)) {
		// storing ACL-id failed, cleanup
		$acl->delete();
		return false;
	}
	
	$user->setPluginSetting('user_support', 'support_ticket_acl', $acl_id);
	
	$cache[$user_guid] = $acl_id;
	return $cache[$user_guid];
}
