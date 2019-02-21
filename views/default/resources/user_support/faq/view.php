<?php

// make sure we have the correct entity
$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', UserSupportFAQ::SUBTYPE);

/* @var $entity UserSupportFAQ */
$entity = get_entity($guid);
$container = $entity->getContainerEntity();

// build page elements
$title_text = $entity->getDisplayName();

elgg_push_entity_breadcrumbs($entity);

$body = elgg_view_entity($entity, [
	'show_responses' => ($entity->allow_comments === 'yes'),
]);

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title_text,
	'content' => $body,
	'entity' => $entity,
	'filter' => false,
]);

// draw page
echo elgg_view_page($title_text, $page_data);
