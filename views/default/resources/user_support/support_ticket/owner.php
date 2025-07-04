<?php

use Elgg\Exceptions\Http\EntityNotFoundException;
use Elgg\Exceptions\Http\EntityPermissionsException;

$user = elgg_get_page_owner_entity();
if (!$user instanceof \ElggUser) {
	throw new EntityNotFoundException();
}

if (!$user->canEdit() && !user_support_is_support_staff()) {
	throw new EntityPermissionsException();
}

$status = elgg_extract('status', $vars, \UserSupportTicket::OPEN);
if (!in_array($status, [\UserSupportTicket::OPEN, \UserSupportTicket::CLOSED])) {
	$status = \UserSupportTicket::OPEN;
}

$q = get_input('q');

$options = [
	'type' => 'object',
	'subtype' => \UserSupportTicket::SUBTYPE,
	'owner_guid' => $user->guid,
	'metadata_name_value_pairs' => [
		'status' => $status,
	],
	'sort_by' => [
		'property' => 'time_updated',
		'direction' => 'DESC',
	],
	'no_results' => true,
];

$getter = 'elgg_get_entities';

if (!empty($q)) {
	$options['query'] = $q;
	$getter = 'elgg_search';
}

$search_route = 'collection:object:support_ticket:owner';
$search_route_params = [
	'username' => $user->username,
];

// build page elements
if ($status === \UserSupportTicket::CLOSED) {
	$search_route_params['status'] = \UserSupportTicket::CLOSED;
	
	if ($user->guid === elgg_get_logged_in_user_guid()) {
		$title_text = elgg_echo('user_support:tickets:mine:archive:title');
	} else {
		$title_text = elgg_echo('user_support:tickets:owner:archive:title', [$user->getDisplayName()]);
	}
} else {
	if ($user->guid === elgg_get_logged_in_user_guid()) {
		$title_text = elgg_echo('user_support:tickets:mine:title');
	} else {
		$title_text = elgg_echo('user_support:tickets:owner:title', [$user->getDisplayName()]);
	}
}

elgg_register_title_button('add', 'object', \UserSupportTicket::SUBTYPE);

$form_vars = [
	'method' => 'GET',
	'disable_security' => true,
	'action' => elgg_generate_url($search_route, $search_route_params),
];
$search = elgg_view_form('user_support/support_ticket/search', $form_vars);

$body = elgg_list_entities($options, $getter);

echo elgg_view_page($title_text, [
	'content' => $search . $body,
	'filter_id' => 'support_ticket',
	'filter_value' => $user->guid === elgg_get_logged_in_user_guid() ? $status !== \UserSupportTicket::CLOSED ? 'mine' : 'my_archive' : 'none',
]);
