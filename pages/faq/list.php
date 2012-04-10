<?php 

	if($user_guid = elgg_get_logged_in_user_guid()){
		elgg_set_page_owner_guid($user_guid);
	}

	elgg_push_context("faq");
	
	// build page elements
	$title_text = elgg_echo("user_support:faq:list:title");
	
	$list_options = array(
		"type" => "object",
		"subtype" => UserSupportFAQ::SUBTYPE,
		"site_guids" => false,
		"full_view" => false
	);
	
	if(!($list = elgg_list_entities($list_options))){
		$list = elgg_echo("notfound");
	}
	
	// build page
	$page_data = elgg_view_layout("content", array(
		"title" => $title_text,
		"content" => $list,
		"filter" => ""
	));
	
	elgg_pop_context();
	
	// draw page
	echo elgg_view_page($title_text, $page_data);
