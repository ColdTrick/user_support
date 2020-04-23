<?php

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', UserSupportTicket::SUBTYPE);

/* @var $entity UserSupportTicket */
$entity = get_entity($guid);
if (!$entity->canEdit()) {
	throw new \Elgg\EntityPermissionsException();
}

// breadcrumb
elgg_push_entity_breadcrumbs($entity, true);

// build page elements
$body_vars = user_support_prepare_ticket_form_vars([
	'entity' => $entity,
]);
$content = elgg_view_form('user_support/support_ticket/edit', [], $body_vars);

echo elgg_view_page($entity->getDisplayName(), ['content' => $content]);
