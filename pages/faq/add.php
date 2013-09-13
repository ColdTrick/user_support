<?php

	gatekeeper();
	
	$user = elgg_get_logged_in_user_entity();
	$page_owner = elgg_get_page_owner_entity();
	
	if (empty($page_owner) || !(elgg_instanceof($page_owner, "site") || elgg_instanceof($page_owner, "group"))) {
		register_error(elgg_echo("pageownerunavailable", array(elgg_get_page_owner_guid())));
		forward(REFERER);
	}
	
	if (elgg_instanceof($page_owner, "group") && !$page_owner->canEdit()) {
		register_error(elgg_echo("user_support:page_owner:cant_edit"));
		forward(REFERER);
	} elseif (elgg_instanceof($page_owner, "site")) {
		admin_gatekeeper();
	}
	
	elgg_push_context("faq");
	
	// make breadcrumb
	elgg_push_breadcrumb(elgg_echo("user_support:menu:faq"), "user_support/faq");
	if (elgg_instanceof($page_owner, "group")) {
		elgg_push_breadcrumb($page_owner->name, "user_support/faq/group/" . $page_owner->getGUID() . "/all");
	}
	elgg_push_breadcrumb(elgg_echo("user_support:faq:create:title"));
	
	// page elements
	$title_text = elgg_echo("user_support:faq:create:title");
	
	$help_context = user_support_find_unique_help_context();
	$content = elgg_view_form("user_support/faq/edit", null, array("help_context" => $help_context));
	
	// build page
	$page_data = elgg_view_layout("content", array(
		"title" => $title_text,
		"content" => $content,
		"filter" => ""
	));
	
	// draw page
	echo elgg_view_page($title_text, $page_data);