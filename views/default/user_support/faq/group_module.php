<?php
/**
 * Group FAQ module
 */

$group = elgg_get_page_owner_entity();
if (!$group instanceof ElggGroup || !user_support_is_group_faq_enabled($group)) {
	return;
}

$all_link = elgg_view('output/url', [
	'href' => "user_support/faq/group/{$group->guid}/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
]);

elgg_push_context('widgets');

$content = elgg_list_entities_from_metadata([
	'type' => 'object',
	'subtype' => UserSupportFAQ::SUBTYPE,
	'container_guid' => $group->guid,
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
	'no_results' => elgg_echo('user_support:faq:not_found'),
]);

elgg_pop_context();

$new_link = '';
if ($group->canEdit()) {
	$new_link = elgg_view('output/url', [
		'href' => "user_support/faq/add/{$group->guid}",
		'text' => elgg_echo('user_support:menu:faq:create'),
		'is_trusted' => true,
	]);
}

echo elgg_view('groups/profile/module', [
	'title' => elgg_echo('user_support:menu:faq:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
]);
