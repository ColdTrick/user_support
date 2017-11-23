<?php

$filter = (array) get_input('filter');
$faq_query = get_input('faq_query');
$filter = array_values($filter); // indexing could be messed up
elgg_push_context('faq');

// build page elements
$title_text = elgg_echo('user_support:faq:list:title');

$list_options = [
	'type' => 'object',
	'subtype' => UserSupportFAQ::SUBTYPE,
	'metadata_name_value_pairs' => [],
	'no_results' => elgg_echo('notfound'),
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
if (!empty($faq_query)) {
	$faq_query = sanitise_string($faq_query);
	
	$list_options['joins'] = [
		'JOIN ' . elgg_get_config('dbprefix') . 'objects_entity oe ON e.guid = oe.guid',
	];
	$list_options['wheres'] = [
		"(oe.title LIKE '%{$faq_query}%' OR oe.description LIKE '%{$faq_query}%')",
	];
}

$list = elgg_list_entities_from_metadata($list_options);

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
	'filter' => '',
]);

elgg_pop_context();

// draw page
echo elgg_view_page($title_text, $page_data);
