<?php

elgg_push_context('faq');

$help_context = elgg_extract('help_context', $vars);
if (empty($help_context)) {
	forward();
}

// build page elements
$title_text = elgg_echo('user_support:faq:context');

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

if (elgg_is_active_plugin('likes')) {
	$dbprefix = elgg_get_config('dbprefix');
	$likes_name_id = elgg_get_metastring_id('likes');
	$faq_options['selects'][] = "IFNULL(likes.likes_count, 0) as likes_count";
	$faq_options['joins'][] = "LEFT OUTER JOIN (SELECT entity_guid, count(*) as likes_count
			FROM " . $dbprefix . "annotations
			WHERE name_id = " . $likes_name_id . "
			GROUP BY entity_guid
			ORDER BY likes_count DESC
		) likes ON likes.entity_guid = e.guid";
	$faq_options['order_by'] = "likes_count DESC, e.time_created DESC";
}
	
$content = elgg_list_entities_from_metadata($faq_options);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $content,
	'filter' => '',
]);

elgg_pop_context();

// draw page
echo elgg_view_page($title_text, $page_data);
