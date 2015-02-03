<?php

elgg_gatekeeper();

$guid = (int) get_input("guid");
elgg_entity_gatekeeper($guid, "object", UserSupportTicket::SUBTYPE);

$entity = get_entity($guid);
if (!$entity->canEdit()) {
	register_error(elgg_echo("limited_access"));
	forward(REFERER);
}

$owner = $entity->getOwnerEntity();

elgg_set_page_owner_guid($owner->getGUID());

$title_text = $entity->title;

// breadcrumb
if ($owner->getGUID() == elgg_get_logged_in_user_guid()) {
	elgg_push_breadcrumb(elgg_echo("user_support:tickets:mine:title"), "user_support/support_ticket/owner/" . $owner->username);
} else {
	elgg_push_breadcrumb(elgg_echo("user_support:tickets:owner:title", array($owner->name)), "user_support/support_ticket/owner/" . $owner->username);
}

elgg_push_breadcrumb($title_text, $entity->getURL());
elgg_push_breadcrumb(elgg_echo("edit"));

// build page
$page_data = elgg_view_layout("content", array(
	"title" => $title_text,
	"content" => elgg_view_form("user_support/support_ticket/edit", array(), array("entity" => $entity)),
	"filter" => ""
));

echo elgg_view_page($title_text, $page_data);
