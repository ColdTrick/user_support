<?php 

	gatekeeper();

	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	
	$status = get_input("status", UserSupportTicket::OPEN);
	if(!in_array($status, array(UserSupportTicket::OPEN, UserSupportTicket::CLOSED))){
		$status = UserSupportTicket::OPEN;
	}
	
	$options = array(
		"type" => "object",
		"subtype" => UserSupportTicket::SUBTYPE,
		"owner_guids" => array(elgg_get_logged_in_user_guid()),
		"full_view" => false,
		"metadata_name_value_pairs" => array("status" => $status),
		"order_by" => "e.time_updated desc"
	);
	
	// build page elements
	if($status == UserSupportTicket::CLOSED){
		$title_text = elgg_echo("user_support:tickets:mine:archive:title");
	} else {
		$title_text = elgg_echo("user_support:tickets:mine:title");
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
	