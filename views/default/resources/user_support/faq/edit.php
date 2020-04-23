<?php

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', UserSupportFAQ::SUBTYPE);

/* @var $entity UserSupportFAQ */
$entity = get_entity($guid);
if (!$entity->canEdit()) {
	throw new \Elgg\EntityPermissionsException();
}

// check for group container
elgg_push_entity_breadcrumbs($entity, true);

// build page elements
$body_vars = user_support_prepare_faq_form_vars([
	'entity' => $entity,
]);
$form = elgg_view_form('user_support/faq/edit', [], $body_vars);

echo elgg_view_page(elgg_echo('user_support:faq:edit:title:edit'), ['content' => $form]);
