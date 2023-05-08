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
		if (elgg_is_xhr()) {
			$referer = _elgg_services()->request->headers->get('referer');
			if (!empty($referer)) {
				$url = elgg_normalize_site_url($referer);
			}
		} else {
			$url = elgg_get_current_url();
		}
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
 * @param \UserSupportTicket $ticket the ticket to get the admins for
 *
 * @return ElggUser[]
 */
function user_support_get_admin_notify_users(\UserSupportTicket $ticket): array {
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
				'type' => ELGG_VALUE_INTEGER,
			],
		],
		'metadata_name_value_pairs_operator' => 'OR',
	]);
	
	// trigger event to get more/less users
	$params = [
		'users' => $users,
		'entity' => $ticket,
	];
	$users = elgg_trigger_event_results('admin_notify', 'user_support', $params, $users);
	if (empty($users)) {
		return [];
	}
	
	if (!is_array($users)) {
		$users = [$users];
	}
	
	return $users;
}

/**
 * Check if a given user GUID is part of the Support staff
 *
 * @param int $user_guid the user GUID to check (default: logged in user)
 *
 * @return bool
 */
function user_support_is_support_staff(int $user_guid = 0): bool {
	static $staff_cache;
	
	if (empty($user_guid)) {
		$user_guid = elgg_get_logged_in_user_guid();
	}
	
	if (empty($user_guid)) {
		return false;
	}
	
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
		
		$options = elgg_trigger_event_results('staff_gatekeeper:options', 'user_support', $options, $options);
		if (!empty($options) && is_array($options)) {
			$staff_cache = elgg_get_entities($options);
		}
	}
	
	if (in_array($user_guid, $staff_cache)) {
		return true;
	}
	
	$user = get_user($user_guid);
	if ($user instanceof \ElggUser && $user->isAdmin()) {
		return true;
	}
	
	return false;
}
