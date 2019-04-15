<?php

// get the page owner
$group_guid = (int) elgg_extract('guid', $vars);

elgg_entity_gatekeeper($group_guid, 'group');

elgg_group_tool_gatekeeper('faq', $group_guid);

$page_owner = elgg_get_page_owner_entity();

// build breadcrumb
elgg_push_collection_breadcrumbs('object', \UserSupportFAQ::SUBTYPE, $page_owner);

elgg_register_title_button('user_support', 'add', 'object', \UserSupportFAQ::SUBTYPE);

// build page elements
$title_text = elgg_echo('user_support:faq:group:title', [$page_owner->getDisplayName()]);

$list_options = [
	'type' => 'object',
	'subtype' => \UserSupportFAQ::SUBTYPE,
	'container_guid' => $page_owner->guid,
	'no_results' => elgg_echo('user_support:faq:not_found'),
];

$content = elgg_list_entities($list_options);

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title_text,
	'content' => $content,
	'filter' => false,
]);

// draw page
echo elgg_view_page($title_text, $page_data);
