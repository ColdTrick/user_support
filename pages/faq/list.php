<?php

	$filter = (array) get_input("filter");
	$filter = array_values($filter); // indexing could be messed up
	elgg_push_context("faq");
	
	// build page elements
	$title_text = elgg_echo("user_support:faq:list:title");
	
	$list_options = array(
		"type" => "object",
		"subtype" => UserSupportFAQ::SUBTYPE,
		"site_guids" => false,
		"full_view" => false,
		"metadata_name_value_pairs" => array()
	);
	
	foreach ($filter as $index => $tag) {
		if ($index > 2) {
			// prevent filtering on too much tags
			break;
		}
		$list_options["metadata_name_value_pairs"][] = array("name" => "tags", "value" => $tag);
	}
	
	if(!($list = elgg_list_entities_from_metadata($list_options))){
		$list = elgg_echo("notfound");
	}
	
	$header = elgg_view("page/layouts/content/header", array("title" => $title_text));
	
	// build page
	$page_data = elgg_view_layout("two_sidebar", array(
		"title" => $title_text,
		"content" => $header . $list,
		"sidebar_alt" => elgg_view("user_support/faq/sidebar")
	));
	
	elgg_pop_context();
	
	// draw page
	echo elgg_view_page($title_text, $page_data);
