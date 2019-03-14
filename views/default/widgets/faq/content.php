<?php

/* @var $widget ElggWidget */
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
];

if ($owner instanceof ElggGroup) {
	$list_options['container_guid'] = $owner->guid;
	
	$more_link = 'collection:object:faq:group';
	$more_link_params['guid'] = $owner->guid;
}

$content = elgg_list_entities($list_options);
if (empty($content)) {
	echo elgg_view('page/components/no_results', [
		'no_results' => elgg_echo('notfound'),
	]);
	return;
}

echo $content;

// read more link
$more_link = elgg_view('output/url', [
	'text' => elgg_echo('user_support:read_more'),
	'href' => elgg_generate_url($more_link, $more_link_params),
]);
echo elgg_format_element('div', ['class' => ['elgg-widget-more']], $more_link);
