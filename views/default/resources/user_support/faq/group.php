<?php

// get the page owner
$group_guid = (int) elgg_extract('guid', $vars);

elgg_group_gatekeeper();
elgg_group_tool_gatekeeper('faq');

$page_owner = elgg_get_page_owner_entity();

// build breadcrumb
elgg_push_collection_breadcrumbs('ojbect', 'faq', $page_owner);

elgg_register_title_button('user_support', 'add', 'object', 'faq');

// build page elements
$title_text = elgg_echo('user_support:faq:group:title', [$page_owner->getDisplayName()]);

$list_options = [
	'type' => 'object',
	'subtype' => \UserSupportFAQ::SUBTYPE,
	'container_guid' => $page_owner->guid,
	'no_results' => elgg_echo('user_support:faq:not_found'),
];

if (elgg_is_active_plugin('likes')) {
	$dbprefix = elgg_get_config('dbprefix');
	
	$likes_name_id = elgg_get_metastring_id('likes');
	$list_options['selects'][] = "IFNULL(likes.likes_count, 0) as likes_count";
	$list_options['joins'][] = "LEFT OUTER JOIN (SELECT entity_guid, count(*) as likes_count
			FROM " . $dbprefix . "annotations
			WHERE name_id = " . $likes_name_id . "
			GROUP BY entity_guid
			ORDER BY likes_count DESC
		) likes ON likes.entity_guid = e.guid";
	$list_options['order_by'] = "likes_count DESC, e.time_created DESC";
}

$content = elgg_list_entities($list_options);

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title_text,
	'content' => $content,
	'filter' => false,
]);

// draw page
echo elgg_view_page($title_text, $page_data);
