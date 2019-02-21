<?php

$guid = (int) elgg_extract('guid', $vars);

// ignore access for support staff
if (user_support_staff_gatekeeper(false)) {
	$ia = elgg_set_ignore_access(true);
}

elgg_entity_gatekeeper($guid, 'object', UserSupportTicket::SUBTYPE);

$entity = get_entity($guid);

// build page elements
$title_text = elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ' . $entity->getDisplayName();

elgg_push_entity_breadcrumbs($entity);

// show entity
$content = elgg_view_entity($entity);

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title_text,
	'content' => $content,
	'filter' => false,
]);

// restore access
if (user_support_staff_gatekeeper(false)) {
	elgg_set_ignore_access($ia);
}

// draw page
echo elgg_view_page($title_text, $page_data);
