<?php

$q = get_input('q');
$content = '';

// search params
$params = [
	'query' => $q,
	'type' => 'object',
	'subtype' => [
		UserSupportHelp::SUBTYPE,
		UserSupportFAQ::SUBTYPE,
	],
	'limit' => 5,
	'offset' => 0,
	'sort' => 'relevance',
	'order' => 'desc',
	'pagination' => false,
	'no_results' => true,
];

$content = elgg_list_entities($params, 'elgg_search');

echo elgg_view_module('info', elgg_echo('search:results', ['\'' . $q . '\'']), $content, ['class' => 'mts']);
