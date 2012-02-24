<?php 

	gatekeeper();

	set_page_owner(get_loggedin_userid());
	
	$status = get_input("status", UserSupportTicket::OPEN);
	if(!in_array($status, array(UserSupportTicket::OPEN, UserSupportTicket::CLOSED))){
		$status = UserSupportTicket::OPEN;
	}
	
	$options = array(
		"type" => "object",
		"subtype" => UserSupportTicket::SUBTYPE,
		"owner_guids" => array(get_loggedin_userid()),
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
	$title = elgg_view_title($title_text);
	
	$context = get_context();
	set_context("search");
	
	if(!($body = elgg_list_entities_from_metadata($options))){
		$body .= elgg_view("page_elements/contentwrapper", array("body" => elgg_echo("user_support:ticket:list:not_found")));
	}
	
	set_context($context);
	
	// build page
	$page_data = $title . $body;
	
	// draw page
	page_draw($title_text, elgg_view_layout("two_column_left_sidebar", "", $page_data));
?>