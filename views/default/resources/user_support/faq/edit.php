<?php

elgg_gatekeeper();

elgg_set_page_owner_guid(elgg_get_site_entity()->guid);

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', UserSupportFAQ::SUBTYPE);

/* @var $entity UserSupportFAQ */
$entity = get_entity($guid);
if (!$entity->canEdit()) {
	register_error(elgg_echo('noaccess'));
	forward(REFERER);
}

// check for group container
$container = $entity->getContainerEntity();
if ($container instanceof ElggGroup) {
	elgg_set_page_owner_guid($container->guid);
	elgg_push_breadcrumb($container->getDisplayName(), "user_support/faq/group/{$container->getGUID()}/all");
}

$page_owner = elgg_get_page_owner_entity();

if (!$page_owner instanceof ElggGroup) {
	elgg_admin_gatekeeper();
}

$title_text = elgg_echo('user_support:faq:edit:title:edit');

// make breadcrumb
elgg_push_breadcrumb($entity->getDisplayName(), $entity->getURL());
elgg_push_breadcrumb($title_text);

// build page elements
$body_vars = user_support_prepare_faq_form_vars([
	'entity' => $entity,
]);
$form = elgg_view_form('user_support/faq/edit', [], $body_vars);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $form,
	'filter' => '',
]);

// draw page
echo elgg_view_page($title_text, $page_data);
