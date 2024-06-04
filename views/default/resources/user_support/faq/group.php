<?php

/* @var $page_owner \ElggGroup */
$page_owner = elgg_get_page_owner_entity();

elgg_group_tool_gatekeeper('faq', $page_owner->guid);

// build breadcrumb
elgg_push_collection_breadcrumbs('object', \UserSupportFAQ::SUBTYPE, $page_owner);

elgg_register_title_button('add', 'object', \UserSupportFAQ::SUBTYPE);

// build page elements
$title_text = elgg_echo('user_support:faq:group:title', [$page_owner->getDisplayName()]);

$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => \UserSupportFAQ::SUBTYPE,
	'container_guid' => $page_owner->guid,
	'no_results' => elgg_echo('user_support:faq:not_found'),
]);

echo elgg_view_page($title_text, [
	'content' => $content,
	'filter_id' => 'faq/group',
]);
