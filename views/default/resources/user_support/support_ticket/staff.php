<?php

user_support_staff_gatekeeper();

$body = elgg_list_entities([
	'type' => 'user',
	'metadata_names' => [
		'support_staff',
	],
	'no_results' => elgg_echo('user_support:tickets:staff:no_results'),
]);

echo elgg_view_page(elgg_echo('user_support:tickets:staff:title'), [
	'content' => $body,
	'filter' => elgg_view_menu('user_support', [
		'class' => 'elgg-tabs',
		'sort_by' => 'priority',
	]),
]);
