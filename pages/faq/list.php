<?php 

	if($user_guid = get_loggedin_userid()){
		set_page_owner($user_guid);
	}

	// build page elements
	$title_text = elgg_echo("user_support:faq:list:title");
	$title = elgg_view_title($title_text);
	
	$list_options = array(
		"type" => "object",
		"subtype" => UserSupportFAQ::SUBTYPE,
		"site_guids" => false,
		"full_view" => false
	);
	
	$context = get_context();
	set_context("search");
	
	if(!($list = elgg_list_entities($list_options))){
		$list .= elgg_view("page_elements/contentwrapper", array("body" => elgg_echo("user_support:faq:not_found")));
	}
	
	set_context($context);
	
	// build page
	$page_data = $title . $list;
	
	// draw page
	page_draw($title_text, elgg_view_layout("two_column_left_sidebar", "", $page_data));

?>