<?php

elgg_gatekeeper();

$username = elgg_extract('username', $vars);
$user = get_user_by_username($username);
if (!$user instanceof ElggUser) {
	register_error(elgg_echo('noaccess'));
	forward(REFERER);
}

if (!$user->canEdit() && !user_support_staff_gatekeeper(false)) {
	register_error(elgg_echo('user_support:staff_gatekeeper'));
	forward(REFERER);
}

elgg_set_page_owner_guid($user->guid);

$status = elgg_extract('status', $vars, UserSupportTicket::OPEN);
if (!in_array($status, [UserSupportTicket::OPEN, UserSupportTicket::CLOSED])) {
	$status = UserSupportTicket::OPEN;
}

$q = get_input('q');

$options = [
	'type' => 'object',
	'subtype' => UserSupportTicket::SUBTYPE,
	'owner_guid' => $user->guid,
	'metadata_name_value_pairs' => [
		'status' => $status,
	],
	'order_by' => 'e.time_updated desc',
	'no_results' => elgg_echo('notfound'),
];

if (!empty($q)) {
	$options['joins'] = [
		'JOIN ' . elgg_get_config('dbprefix') . 'objects_entity oe ON e.guid = oe.guid',
	];
	$options['wheres'] = [
		'oe.description LIKE "%' . sanitise_string($q) . '%"',
	];
}

$search_action = 'user_support/support_ticket/owner/' . $user->username;

elgg_push_context('support_ticket_title');

// build page elements
if ($status == UserSupportTicket::CLOSED) {
	$search_action .= '/archive';
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

$form_vars = [
	'method' => 'GET',
	'disable_security' => true,
	'action' => $search_action,
];
$search = elgg_view_form('user_support/support_ticket/search', $form_vars);

$body = elgg_list_entities_from_metadata($options);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $search . $body,
	'filter' => elgg_view_menu('user_support', ['class' => 'elgg-tabs']),
]);

elgg_pop_context();

// draw page
echo elgg_view_page($title_text, $page_data);
