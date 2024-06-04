<?php

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);
$owner = $widget->getOwnerEntity();

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 4;
}

$list_options = [
	'type' => 'object',
	'subtype' => \UserSupportFAQ::SUBTYPE,
	'limit' => $num_display,
	'pagination' => false,
	'no_results' => true,
	'widget_more' => elgg_view_url($widget->getURL(), elgg_echo('user_support:read_more'))
];

if ($owner instanceof \ElggGroup) {
	$list_options['container_guid'] = $owner->guid;
}

echo elgg_list_entities($list_options);
