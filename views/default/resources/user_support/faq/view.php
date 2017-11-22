<?php

// make sure we have the correct entity
$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', UserSupportFAQ::SUBTYPE);

/* @var $entity UserSupportFAQ */
$entity = get_entity($guid);
$container = $entity->getContainerEntity();

// build page elements
$title_text = $entity->getDisplayName();

// make breadcrumb
if ($container instanceof ElggGroup) {
	elgg_push_breadcrumb($container->getDisplayName(), "user_support/faq/group/{$container->guid}/all");
	elgg_set_page_owner_guid($container->getGUID());
}
elgg_push_breadcrumb($title_text);

$body = elgg_view_entity($entity);

$comments = '';
if ($entity->allow_comments === 'yes') {
	$comments = elgg_view_comments($entity);
}

// build page
$page_data = elgg_view_layout('content', [
	'title' => elgg_echo('user_support:question') . ': ' . $title_text,
	'content' => $body . $comments,
	'filter' => '',
]);

// draw page
echo elgg_view_page($title_text, $page_data);
