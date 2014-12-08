<?php

if ($user_guid = elgg_get_logged_in_user_guid()) {
	elgg_set_page_owner_guid($user_guid);
}

// make sure we have the correct entity
$guid = (int) get_input("guid");
elgg_entity_gatekeeper($guid, "object", UserSupportFAQ::SUBTYPE);

$entity = get_entity($guid);
$container = $entity->getContainerEntity();

// build page elements
$title_text = $entity->title;

// make breadcrumb
if (elgg_instanceof($container, "group")) {
	elgg_push_breadcrumb($container->name, "user_support/faq/group/" . $container->getGUID() . "/all");
	elgg_set_page_owner_guid($container->getGUID());
}
elgg_push_breadcrumb($title_text);

$body = elgg_view_entity($entity, array(
	"full_view" => true
));

$comments = "";
if ($entity->canComment()) {
	$comments = elgg_view_comments($entity);
}

// build page
$page_data = elgg_view_layout("content", array(
	"title" => elgg_echo("user_support:question") . ": " . $title_text,
	"content" => $body . $comments,
	"filter" => ""
));

// draw page
echo elgg_view_page($title_text, $page_data);
