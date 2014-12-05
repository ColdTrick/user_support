<?php

elgg_gatekeeper();

elgg_set_page_owner_guid(elgg_get_site_entity()->getGUID());

$title_text = "";
$entity = null;
$guid = (int) get_input("guid");
if (!empty($guid) && ($entity = get_entity($guid))) {
	if (elgg_instanceof($entity, "object", UserSupportFAQ::SUBTYPE, "UserSupportFAQ")) {
		
		$title_text = elgg_echo("user_support:faq:edit:title:edit");
		
		// check for group container
		$container = $entity->getContainerEntity();
		if (elgg_instanceof($container, "group")) {
			elgg_set_page_owner_guid($container->getGUID());
			elgg_push_breadcrumb($container->name, "user_support/faq/group/" . $container->getGUID() . "/all");
		}
	}
}

$page_owner = elgg_get_page_owner_entity();

if (elgg_instanceof($page_owner, "group") && !$page_owner->canEdit()) {
	register_error(elgg_echo("user_support:page_owner:cant_edit"));
	forward(REFERER);
} elseif (elgg_instanceof($page_owner, "site")) {
	elgg_admin_gatekeeper();
}

// make breadcrumb
elgg_push_breadcrumb($title_text);

$help_context = user_support_find_unique_help_context();
$body_vars = array(
	"entity" => $entity,
	"help_context" => $help_context
);
$form = elgg_view_form("user_support/faq/edit", array(), $body_vars);

// build page
$page_data = elgg_view_layout("content", array(
	"title" => $title_text,
	"content" => $form,
	"filter" => ""
));

// draw page
echo elgg_view_page($title_text, $page_data);
