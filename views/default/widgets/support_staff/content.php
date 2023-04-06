<?php

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 4;
}

$options = [
	'type' => 'object',
	'subtype' => \UserSupportTicket::SUBTYPE,
	'limit' => $num_display,
	'metadata_name_value_pairs' => [
		'status' => \UserSupportTicket::OPEN,
	],
	'pagination' => false,
	'sort_by' => [
		'property' => 'time_updated',
		'direction' => 'desc',
		'signed' => true,
	],
	'no_results' => true,
	'widget_more' => elgg_view_url(elgg_generate_url('collection:object:support_ticket:all'), elgg_echo('user_support:read_more')),
];

echo elgg_list_entities($options);
