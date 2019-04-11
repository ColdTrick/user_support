<?php

use Elgg\BadRequestException;

$help_context = get_input('help_context');
if (empty($help_context)) {
	throw new BadRequestException();
}

// build page elements
$title_text = elgg_echo('user_support:faq:context');

elgg_push_collection_breadcrumbs('object', 'faq');

$faq_options = [
	'type' => 'object',
	'subtype' => UserSupportFAQ::SUBTYPE,
	'metadata_name_value_pairs' => [
		[
			'name' => 'help_context',
			'value' => $help_context,
		],
	],
	'no_results' => elgg_echo('user_support:faq:not_found'),
];
	
$content = elgg_list_entities($faq_options);

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title_text,
	'content' => $content,
	'filter' => false,
]);

// draw page
echo elgg_view_page($title_text, $page_data);
