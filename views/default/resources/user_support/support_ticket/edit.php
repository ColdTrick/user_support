<?php

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', \UserSupportTicket::SUBTYPE, true);

/* @var $entity \UserSupportTicket */
$entity = get_entity($guid);

// breadcrumb
elgg_push_entity_breadcrumbs($entity);

// build page elements
$content = elgg_view_form('user_support/support_ticket/edit', [
	'sticky_enabled' => true,
], [
	'entity' => $entity,
]);

echo elgg_view_page($entity->getDisplayName(), [
	'content' => $content,
	'filter_id' => 'support_ticker/edit',
	'filter_value' => 'edit',
]);
