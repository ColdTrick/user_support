<?php

/* @var $widget ElggWidget */
$widget = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:widgets:support_ticket:filter'),
	'name' => 'params[filter]',
	'value' => $widget->filter,
	'options_values' => [
		\UserSupportTicket::OPEN => elgg_echo('user_support:support_type:status:open'),
		\UserSupportTicket::CLOSED => elgg_echo('user_support:support_type:status:closed'),
		'all' => elgg_echo('user_support:widgets:support_ticket:filter:all'),
	],
]);

echo elgg_view('object/widget/edit/num_display', [
	'entity' => $widget,
	'default' => 4,
	'min' => 1,
	'max' => 99,
]);
