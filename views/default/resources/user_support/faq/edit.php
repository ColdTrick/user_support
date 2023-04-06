<?php

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', \UserSupportFAQ::SUBTYPE, true);

/* @var $entity \UserSupportFAQ */
$entity = get_entity($guid);

// check for group container
elgg_push_entity_breadcrumbs($entity, true);

// build page elements
$form = elgg_view_form('user_support/faq/edit', [
	'sticky_enabled' => true,
], [
	'entity' => $entity,
]);

echo elgg_view_page(elgg_echo('user_support:faq:edit:title:edit'), [
	'content' => $form,
	'filter' => false,
]);
