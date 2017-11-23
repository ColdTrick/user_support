<?php

// get the page owner
$group_guid = (int) elgg_extract('guid', $vars);
elgg_set_page_owner_guid($group_guid);

$page_owner = elgg_get_page_owner_entity();

if (!$page_owner instanceof ElggGroup) {
	register_error(elgg_echo('user_support:page_owner:not_group'));
	forward(REFERER);
}

elgg_group_gatekeeper();

elgg_push_context('faq');

// build breadcrumb
elgg_push_breadcrumb($page_owner->getDisplayName());

// build page elements
$title_text = elgg_echo('user_support:faq:group:title', [$page_owner->getDisplayName()]);

$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => UserSupportFAQ::SUBTYPE,
	'container_guid' => $page_owner->guid,
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
