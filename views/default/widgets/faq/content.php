<?php

/* @var $widget ElggWidget */
$widget = elgg_extract('entity', $vars);
$owner = $widget->getOwnerEntity();

$more_link = 'user_support/faq';

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 4;
}

$options = [
	'type' => 'object',
	'subtype' => UserSupportFAQ::SUBTYPE,
	'limit' => $num_display,
	'pagination' => false,
];

if ($owner instanceof ElggGroup) {
	$options['container_guid'] = $owner->guid;
	
	$more_link .= "/group/{$owner->guid}/all";
}

$content = elgg_list_entities($options);
if (empty($content)) {
	echo elgg_view('output/longtext', [
		'value' => elgg_echo('user_support:faq:not_found'),
	]);
	return;
}

echo $content;

// read more link
$more_link = elgg_view('output/url', [
	'text' => elgg_echo('user_support:read_more'),
	'href' => $more_link,
	'class' => 'float-alt',
]);
echo elgg_format_element('div', ['class' => ['elgg-widget-more', 'clearfix']], $more_link);
