<?php

use Elgg\Database\Clauses\OrderByClause;

/* @var $widget ElggWidget */
$widget = elgg_extract('entity', $vars);

$num_display = (int) $widget->num_display;
if ($num_display < 1) {
	$num_display = 4;
}

$options = [
	'type' => 'object',
	'subtype' => UserSupportTicket::SUBTYPE,
	'limit' => $num_display,
	'metadata_name_value_pairs' => [
		'status' => UserSupportTicket::OPEN,
	],
	'pagination' => false,
	'order_by' => new OrderByClause('e.time_updated', 'desc'),
];

$content = elgg_list_entities($options);
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
	'href' => 'user_support/support_ticket',
]);
echo elgg_format_element('div', ['class' => ['elgg-widget-more']], $more_link);
