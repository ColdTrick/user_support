<?php

elgg_push_context('faq');

$help_context = elgg_extract('help_context', $vars);
if (empty($help_context)) {
	forward();
}

// build page elements
$title_text = elgg_echo('user_support:faq:context');

$content = elgg_list_entities_from_metadata([
	'type' => 'object',
	'subtype' => UserSupportFAQ::SUBTYPE,
	'metadata_name_value_pairs' => [
		[
			'name' => 'help_context',
			'value' => $help_context,
		],
	],
	'no_results' => elgg_echo('user_support:faq:not_found'),
]);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $content,
	'filter' => '',
]);

elgg_pop_context();

// draw page
echo elgg_view_page($title_text, $page_data);
