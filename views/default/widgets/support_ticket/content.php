<?php

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);
$owner = $widget->getOwnerEntity();

$filter = $widget->filter;
if (empty($filter)) {
	$filter = UserSupportTicket::OPEN;
}

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 4;
}

$more_link = 'collection:object:support_ticket:owner';
$more_link_params = [
	'username' => $owner->username,
];

$options = [
	'type' => 'object',
	'subtype' => UserSupportTicket::SUBTYPE,
	'owner_guid' => $widget->owner_guid,
	'limit' => $num_display,
	'pagination' => false,
	'sort_by' => [
		'property' => 'time_updated',
		'direction' => 'desc',
		'signed' => true,
	],
	'no_results' => true,
];

if ($filter != 'all') {
	$options['metadata_name_value_pairs'] = [
		'status' => $filter,
	];
	
	if ($filter === \UserSupportTicket::CLOSED) {
		$more_link_params['status'] = \UserSupportTicket::CLOSED;
	}
}

$options['widget_more'] = elgg_view_url(elgg_generate_url($more_link, $more_link_params), elgg_echo('user_support:read_more'));

echo elgg_list_entities($options);
