<?php

elgg_gatekeeper();

$guid = (int) elgg_extract('guid', $vars);

// ignore access for support staff
if (user_support_staff_gatekeeper(false)) {
	$ia = elgg_set_ignore_access(true);
}

elgg_entity_gatekeeper($guid, 'object', UserSupportTicket::SUBTYPE);

$entity = get_entity($guid);

elgg_set_page_owner_guid($entity->owner_guid);

// build page elements
$title = $entity->getDisplayName();
$title_text = elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ' . $title;

// build breadcrumb
if ($entity->owner_guid === elgg_get_logged_in_user_guid()) {
	elgg_push_breadcrumb(elgg_echo('user_support:menu:support_tickets:mine'), 'user_support/support_ticket/owner/' . $entity->getOwnerEntity()->username);
} else {
	elgg_push_breadcrumb(elgg_echo('user_support:menu:support_tickets'), 'user_support/support_ticket');
}
elgg_push_breadcrumb($title);

// show entity
$content = elgg_view_entity($entity);

// add comments
$content .= elgg_view_comments($entity);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $content,
	'filter' => '',
]);

// restore access
if (user_support_staff_gatekeeper(false)) {
	elgg_set_ignore_access($ia);
}

// draw page
echo elgg_view_page($title_text, $page_data);
