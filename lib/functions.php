<?php
/**
 * All helper functions are bundled here
 */

/**
 * Get the help for a context
 *
 * @param string $help_context the context to get help for
 *
 * @return false|UserSupportHelp
 */
function user_support_get_help_for_context($help_context) {
	
	if (empty($help_context)) {
		return false;
	}
	
	$help = elgg_get_entities_from_metadata([
		'type' => 'object',
		'subtype' => UserSupportHelp::SUBTYPE,
		'limit' => false,
		'metadata_name_value_pairs' => [
			'help_context' => $help_context,
		],
	]);
	if (empty($help)) {
		return false;
	}
	
	return $help[0];
}

/**
 * Get the context for a page, for the help system
 *
 * @param string $url the (optional) url to get the context for
 *
 * @return false|string
 */
function user_support_get_help_context($url = '') {
	
	if (empty($url)) {
		$url = current_page_url();
	}
	
	if (empty($url)) {
		return false;
	}
	
	$path = parse_url($url, PHP_URL_PATH);
	if (empty($path)) {
		return false;
	}
	
	$parts = explode('/', $path);
	
	$page_owner = elgg_get_page_owner_entity();
	if (empty($page_owner)) {
		$page_owner = elgg_get_logged_in_user_entity();
	}
	
	$new_parts = [];
	
	foreach ($parts as $index => $part) {
		
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
 * Helper function to build a better time string
 *
 * @param ElggObject $entity the object to build the string for
 *
 * @return false|string
 */
function user_support_time_created_string(ElggObject $entity) {
	
	if (!$entity instanceof ElggObject) {
		return false;
	}
	
	$date_array = getdate($entity->time_created);
	if (empty($date_array)) {
		return false;
	}
	
	return elgg_echo('date:month:' . str_pad($date_array['mon'], 2, '0', STR_PAD_LEFT), [$date_array['mday']]) . ' ' . $date_array['year'];
}

/**
 * Get a list of all the unique help contexts
 *
 * @return false|array
 */
function user_support_find_unique_help_context() {
	static $result;
	
	if (isset($result)) {
		return $result;
	}
	
	$result = false;
	
	// get all metadata values of help_context
	$metadata = elgg_get_metadata([
		'metadata_name' => 'help_context',
		'type' => 'object',
		'subtypes' => [
			UserSupportFAQ::SUBTYPE,
			UserSupportHelp::SUBTYPE,
			UserSupportTicket::SUBTYPE,
		],
		'limit' => false,
	]);
	if (empty($metadata)) {
		return $result;
	}
	
	// make it into an array
	$filtered = metadata_array_to_values($metadata);
	if (empty($filtered)) {
		return $result;
	}
	
	//get unique values
	$result = array_unique($filtered);
	natcasesort($result);
	
	return $result;
}

/**
 * Get all the admins that need a notification about a ticket
 *
 * @param UserSupportTicket $ticket the ticket to get the admins for
 *
 * @return false|ElggUser[]
 */
function user_support_get_admin_notify_users(UserSupportTicket $ticket) {
	
	if (!$ticket instanceof UserSupportTicket) {
		return false;
	}
	
	$dbprefix = elgg_get_config('dbprefix');
	$support_staff_id = elgg_get_metastring_id('support_staff');
	
	$users = elgg_get_entities_from_relationship([
		'type' => 'user',
		'limit' => false,
		'joins' => [
			"JOIN {$dbprefix}private_settings ps ON e.guid = ps.entity_guid",
			"JOIN {$dbprefix}users_entity ue ON e.guid = ue.guid",
			"JOIN {$dbprefix}metadata md ON e.guid = md.entity_guid",
		],
		'wheres' => [
			'(ps.name = "' . ELGG_PLUGIN_USER_SETTING_PREFIX . 'user_support:admin_notify" AND ps.value = "yes")',
			"(ue.admin = 'yes' OR md.name_id = '{$support_staff_id}')",
			"(e.guid <> {$ticket->owner_guid})",
		],
	]);
		
	// trigger hook to get more/less users
	$users = elgg_trigger_plugin_hook('admin_notify', 'user_support', ['users' => $users, 'entity' => $ticket], $users);
	if (empty($users)) {
		return false;
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
function user_support_staff_gatekeeper($forward = true, $user_guid = 0) {
	static $staff_cache;
	
	$result = false;
	
	$user_guid = sanitise_int($user_guid, false);
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
				$staff_cache = elgg_get_entities_from_metadata($options);
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
		register_error(elgg_echo('user_support:staff_gatekeeper'));
		forward(REFERER);
	}
	
	return $result;
}

/**
 * Helper function to return only the GUID of a DB row
 *
 * @param stdClass $row the database row
 *
 * @return int
 */
function user_support_row_to_guid($row) {
	return (int) $row->guid;
}
