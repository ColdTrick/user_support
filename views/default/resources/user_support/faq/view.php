<?php

// make sure we have the correct entity
$guid = (int) elgg_extract('guid', $vars);

/** @var \UserSupportFAQ $entity */
$entity = elgg_entity_gatekeeper($guid, 'object', \UserSupportFAQ::SUBTYPE);

elgg_push_entity_breadcrumbs($entity);

echo elgg_view_page($entity->getDisplayName(), [
	'content' => elgg_view_entity($entity),
	'entity' => $entity,
	'filter' => false,
]);
