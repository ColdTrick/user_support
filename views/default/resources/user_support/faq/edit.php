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

$title_text = elgg_echo('user_support:faq:edit:title:edit');

// build page elements
$body_vars = user_support_prepare_faq_form_vars([
	'entity' => $entity,
]);
$form = elgg_view_form('user_support/faq/edit', [], $body_vars);

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title_text,
	'content' => $form,
	'filter' => false,
]);

// draw page
echo elgg_view_page($title_text, $page_data);
