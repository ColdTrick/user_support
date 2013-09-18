<?php

	gatekeeper();

	$user = elgg_get_page_owner_entity();
	
	if (!$user->canEdit() && !user_support_staff_gatekeeper(false)) {
		register_error(elgg_echo("user_support:staff_gatekeeper"));
		forward(REFERER);
	}
	
	$status = get_input("status", UserSupportTicket::OPEN);
	if(!in_array($status, array(UserSupportTicket::OPEN, UserSupportTicket::CLOSED))){
		$status = UserSupportTicket::OPEN;
	}
	
	$options = array(
		"type" => "object",
		"subtype" => UserSupportTicket::SUBTYPE,
		"owner_guid" => $user->getGUID(),
		"full_view" => false,
		"metadata_name_value_pairs" => array("status" => $status),
		"order_by" => "e.time_updated desc"
	);
	
	// build page elements
	if ($status == UserSupportTicket::CLOSED) {
		if ($user->getGUID() == elgg_get_logged_in_user_guid()) {
			$title_text = elgg_echo("user_support:tickets:mine:archive:title");
		} else {
			$title_text = elgg_echo("user_support:tickets:owner:archive:title", array($user->name));
		}
	} else {
		if ($user->getGUID() == elgg_get_logged_in_user_guid()) {
			$title_text = elgg_echo("user_support:tickets:mine:title");
		} else {
			$title_text = elgg_echo("user_support:tickets:owner:title", array($user->name));
		}
	}
	
	if(!($body = elgg_list_entities_from_metadata($options))){
		$body .= elgg_echo("notfound");
	}
	
	// build page
	$page_data = elgg_view_layout("content", array(
		"title" => $title_text,
		"content" => $body,
		"filter" => elgg_view_menu("user_support", array("class" => "elgg-tabs"))
	));
	
	// draw page
	echo elgg_view_page($title_text, $page_data);
	