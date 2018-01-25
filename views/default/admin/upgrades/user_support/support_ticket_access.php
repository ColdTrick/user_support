<?php

// Upgrade also possible hidden entities. This feature get run
// by an administrator so there's no need to ignore access.
$access_status = access_show_hidden_entities(true);

$count = elgg_get_entities([
	'type' => 'object',
	'subtype' => UserSupportTicket::SUBTYPE,
	'count' => true,
	'wheres' => [
		'e.access_id = ' . ACCESS_PRIVATE,
	],
]);

echo elgg_view('output/longtext', [
	'value' => elgg_echo('admin:upgrades:user_support:support_ticket_access:description'),
]);

echo elgg_view('admin/upgrades/view', [
	'count' => $count,
	'action' => 'action/user_support/upgrades/support_ticket_access',
]);
access_show_hidden_entities($access_status);
