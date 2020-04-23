<?php

use Elgg\Database\QueryBuilder;
use ColdTrick\UserSupport\Database\TagFilter;

$filter = (array) get_input('filter');
$faq_query = get_input('faq_query');
$filter = array_values($filter); // indexing could be messed up

elgg_register_title_button('user_support', 'add', 'object', 'faq');

$list_options = [
	'type' => 'object',
	'subtype' => UserSupportFAQ::SUBTYPE,
	'wheres' => [],
	'no_results' => true,
];

if (!empty($filter)) {
	$list_options['wheres'][] = function (QueryBuilder $qb, $main_alias) use ($filter) {
		// add tag filter
		$filter = new TagFilter($filter);
		
		return $filter($qb, $main_alias);
	};
}

// text search
$getter = 'elgg_get_entities';

if (!empty($faq_query)) {
	$list_options['query'] = $faq_query;
	
	$getter = 'elgg_search';
}

$list = elgg_list_entities($list_options, $getter);

$form_vars = [
	'action' => 'user_support/faq',
	'disable_security' => true,
	'method' => 'GET',
];
$body_vars = [
	'filter' => $filter,
];
$search = elgg_view_form('user_support/faq/search', $form_vars, $body_vars);

echo elgg_view_page(elgg_echo('user_support:faq:list:title'), [
	'content' => $search . $list,
	'sidebar' => elgg_view('user_support/faq/sidebar'),
]);
