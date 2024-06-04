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

$options = [
	'type' => 'object',
	'subtype' => \UserSupportTicket::SUBTYPE,
	'owner_guid' => $widget->owner_guid,
	'limit' => $num_display,
	'pagination' => false,
	'sort_by' => [
		'property' => 'time_updated',
		'direction' => 'desc',
		'signed' => true,
	],
	'no_results' => true,
	'widget_more' => elgg_view_url($widget->getURL(), elgg_echo('user_support:read_more'))
];

if ($filter != 'all') {
	$options['metadata_name_value_pairs'] = [
		'status' => $filter,
	];
}

echo elgg_list_entities($options);
