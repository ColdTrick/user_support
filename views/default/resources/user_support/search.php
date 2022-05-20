<?php

$q = get_input('q');

$content = elgg_list_entities([
	'query' => $q,
	'type' => 'object',
	'subtype' => [
		UserSupportHelp::SUBTYPE,
		UserSupportFAQ::SUBTYPE,
	],
	'limit' => 5,
	'offset' => 0,
	'pagination' => false,
	'no_results' => true,
], 'elgg_search');

echo elgg_view_module('info', elgg_echo('search:results', ['\'' . $q . '\'']), $content, ['class' => 'mts']);
