<?php

$filter = (array) get_input('filter');
$faq_query = get_input('faq_query');
$filter = array_values($filter); // indexing could be messed up

elgg_register_title_button('user_support', 'add', 'object', 'faq');

// build page elements
$title_text = elgg_echo('user_support:faq:list:title');

$list_options = [
	'type' => 'object',
	'subtype' => UserSupportFAQ::SUBTYPE,
	'metadata_name_value_pairs' => [],
	'no_results' => true,
];

// add tag filter
foreach ($filter as $index => $tag) {
	if ($index > 2) {
		// prevent filtering on too much tags
		break;
	}
	$list_options['metadata_name_value_pairs'][] = [
		'name' => 'tags',
		'value' => $tag,
	];
}

// text search
$getter = 'elgg_get_entities';

if (!empty($q)) {
	$options['query'] = $faq_query;
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

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $search . $list,
	'sidebar' => elgg_view('user_support/faq/sidebar'),
	'filter' => false,
]);

// draw page
echo elgg_view_page($title_text, $page_data);
