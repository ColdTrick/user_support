<?php 

	admin_gatekeeper();
	
	$options = array(
		"type" => "object",
		"subtype" => UserSupportTicket::SUBTYPE,
		"full_view" => false,
		"metadata_name_value_pairs" => array("status" => UserSupportTicket::OPEN),
		"order_by" => "e.time_updated desc"
	);
	
	// build page elements
	$title_text = elgg_echo("user_support:tickets:list:title");
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