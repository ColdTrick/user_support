<?php

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', UserSupportTicket::SUBTYPE);

/* @var $entity UserSupportTicket */
$entity = get_entity($guid);
if (!$entity->canEdit()) {
	throw new \Elgg\EntityPermissionsException();
}

$title_text = $entity->getDisplayName();

// breadcrumb
elgg_push_entity_breadcrumbs($entity, true);

// build page elements
$body_vars = user_support_prepare_ticket_form_vars([
	'entity' => $entity,
]);
$content = elgg_view_form('user_support/support_ticket/edit', [], $body_vars);

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title_text,
	'content' => $content,
	'filter' => false,
]);

// draw page
echo elgg_view_page($title_text, $page_data);
