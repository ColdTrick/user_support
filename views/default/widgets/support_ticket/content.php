<?php

/* @var $widget ElggWidget */
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

$more_link = 'user_support/support_ticket/owner/' . $owner->username;

$options = [
	'type' => 'object',
	'subtype' => UserSupportTicket::SUBTYPE,
	'owner_guid' => $widget->owner_guid,
	'limit' => $num_display,
	'pagination' => false,
	'order_by' => 'e.time_updated desc',
];

if ($filter != 'all') {
	$options['metadata_name_value_pairs'] = [
		'status' => $filter,
	];
	
	if ($filter == UserSupportTicket::CLOSED) {
		$more_link .= '/archive';
	}
}

$content = elgg_list_entities_from_metadata($options);
if (empty($content)) {
	echo elgg_view('output/longtext', [
		'value' => elgg_echo('notfound'),
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
