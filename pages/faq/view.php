<?php 

	if($user_guid = get_loggedin_userid()){
		set_page_owner($user_guid);
	}
	
	$forward = true;
	$guid = (int) get_input("guid");
	if($entity = get_entity($guid)){
		if($entity->getSubtype() == UserSupportFAQ::SUBTYPE){
			$forward = false;
			
			// build page elements
			$title_text = $entity->title;
			
			$body = elgg_view_entity($entity, true);
			
			if($entity->allow_comments == "yes"){
				$comments = elgg_view_comments($entity);
			}
			
			// build page
			$page_data = $body . $comments;
		}
	}

	if(!$forward){
		// draw page
		page_draw($title_text, elgg_view_layout("two_column_left_sidebar", "", $page_data));
	} else {
		forward();
	}

?>