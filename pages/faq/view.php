<?php 

	if($user_guid = elgg_get_logged_in_user_guid()){
		elgg_set_page_owner_guid($user_guid);
	}
	
	$forward = true;
	$guid = (int) get_input("guid");
	
	if(($entity = get_entity($guid)) && elgg_instanceof($entity, "object", UserSupportFAQ::SUBTYPE, "UserSupportFAQ")){
		$forward = false;
		
		// build page elements
		$title_text = $entity->title;
		
		// make breadcrumb
		elgg_push_breadcrumb(elgg_echo("user_support:menu:faq"), "user_support/faq");
		elgg_push_breadcrumb($title_text);
		
		$body = elgg_view_entity($entity, array(
			"full_view" => true
		));
		
		if($entity->allow_comments == "yes"){
			$comments = elgg_view_comments($entity);
		}
		
		// build page
		$page_data = elgg_view_layout("content", array(
			"title" => elgg_echo("user_support:question") . ": " . $title_text,
			"content" => $body . $comments,
			"filter" => ""
		));
	}

	if(!$forward){
		// draw page
		echo elgg_view_page($title_text, $page_data);
	} else {
		forward(REFERER);
	}