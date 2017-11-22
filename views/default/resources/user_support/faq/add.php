<?php

elgg_gatekeeper();

$container_guid = (int) elgg_extract('guid', $vars);
elgg_set_page_owner_guid($container_guid);

$page_owner = elgg_get_page_owner_entity();

if (empty($page_owner) || !($page_owner instanceof ElggSite || $page_owner instanceof ElggGroup)) {
	register_error(elgg_echo('pageownerunavailable', [elgg_get_page_owner_guid()]));
	forward(REFERER);
}

if ($page_owner instanceof ElggGroup && !$page_owner->canEdit()) {
	register_error(elgg_echo('user_support:page_owner:cant_edit'));
	forward(REFERER);
} else {
	elgg_admin_gatekeeper();
}

$annotation = false;
if (elgg_is_admin_logged_in()) {
	// @todo this should be moved to an ElggComment
	$annotation_id = (int) get_input('annotation');
	$temp_anno = elgg_get_annotation_from_id($annotation_id);
	if ($temp_anno instanceof ElggAnnotation) {
		$entity = $temp_anno->getEntity();
		if ($entity instanceof UserSupportTicket) {
			$annotation = $temp_anno;
		}
	}
}

elgg_push_context('faq');

// make breadcrumb
if ($page_owner instanceof ElggGroup) {
	elgg_push_breadcrumb($page_owner->getDisplayName(), "user_support/faq/group/{$page_owner->guid}/all");
}
elgg_push_breadcrumb(elgg_echo('user_support:faq:create:title'));

// page elements
$title_text = elgg_echo('user_support:faq:create:title');

$body_vars = [
	'help_context' => user_support_find_unique_help_context(),
	'annotation' => $annotation,
];
$content = elgg_view_form('user_support/faq/edit', [], $body_vars);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $content,
	'filter' => '',
]);

// draw page
echo elgg_view_page($title_text, $page_data);
