<?php

// make sure we have the correct entity
$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', \UserSupportFAQ::SUBTYPE);

/* @var $entity \UserSupportFAQ */
$entity = get_entity($guid);

elgg_push_entity_breadcrumbs($entity);

$body = elgg_view_entity($entity, [
	'show_responses' => ($entity->allow_comments === 'yes'),
]);

echo elgg_view_page($entity->getDisplayName(), [
	'content' => $body,
	'entity' => $entity,
	'filter' => false,
]);
