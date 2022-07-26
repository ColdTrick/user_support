<?php

/* @var $widget \ElggWidget */
$widget = elgg_extract('entity', $vars);
$owner = $widget->getOwnerEntity();

$more_link = 'collection:object:faq:all';
$more_link_params = [];

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 4;
}

$list_options = [
	'type' => 'object',
	'subtype' => UserSupportFAQ::SUBTYPE,
	'limit' => $num_display,
	'pagination' => false,
	'no_results' => true,
];

if ($owner instanceof ElggGroup) {
	$list_options['container_guid'] = $owner->guid;
	
	$more_link = 'collection:object:faq:group';
	$more_link_params['guid'] = $owner->guid;
}

$list_options['widget_more'] = elgg_view_url(elgg_generate_url($more_link, $more_link_params), elgg_echo('user_support:read_more'));

echo elgg_list_entities($list_options);
