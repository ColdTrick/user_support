<?php

/* @var $widget ElggWidget */
$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 4;
}

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo("user_support:widgets:support_ticket:filter"),
	'name' => 'params[filter]',
	'value' => $widget->filter,
	'options_values' => [
		UserSupportTicket::OPEN => elgg_echo('user_support:support_type:status:open'),
		UserSupportTicket::CLOSED => elgg_echo('user_support:support_type:status:closed'),
		'all' => elgg_echo('user_support:widgets:support_ticket:filter:all'),
	],
]);

echo elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo("widget:numbertodisplay"),
	'name' => 'params[num_display]',
	'value' => $num_display,
	'min' => 1,
	'max' => 99,
]);
