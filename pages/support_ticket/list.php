<?php 

	admin_gatekeeper();
	
	$options = array(
		"type" => "object",
		"subtype" => UserSupportTicket::SUBTYPE,
		"full_view" => false,
		"metadata_name_value_pairs" => array("status" => UserSupportTicket::OPEN),
		"order_by" => "e.time_updated DESC"
	);
	
	// build page elements
	$title_text = elgg_echo("user_support:tickets:list:title");
	
	if(!($body = elgg_list_entities_from_metadata($options))){
		$body = elgg_echo("notfound");
	}
	
	// build page
	$page_data = elgg_view_layout("content", array(
		"title" => $title_text,
		"content" => $body,
		"filter" => elgg_view_menu("user_support", array("class" => "elgg-tabs"))
	));
	
	// draw page
	echo elgg_view_page($title_text, $page_data);
	