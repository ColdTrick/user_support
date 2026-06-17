<?php

$guid = (int) elgg_extract('guid', $vars);

/** @var \UserSupportFAQ $entity */
$entity = elgg_entity_gatekeeper($guid, 'object', \UserSupportFAQ::SUBTYPE, true);

elgg_push_entity_breadcrumbs($entity);

$form = elgg_view_form('user_support/faq/edit', [
	'sticky_enabled' => true,
], [
	'entity' => $entity,
]);

echo elgg_view_page(elgg_echo('user_support:faq:edit:title:edit'), [
	'content' => $form,
	'filter' => false,
]);
