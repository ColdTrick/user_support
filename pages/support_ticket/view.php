<?php 

	gatekeeper();
	
	$guid = (int) get_input("guid");

	$forward = true;
	
	if($entity = get_entity($guid)){
		if($entity instanceof UserSupportTicket){
			set_page_owner($entity->getOwner());
			$forward = false;
			
			// build page elements
			$title_text = $entity->title;
			
			$body = elgg_view_entity($entity, true, false);
			
			// build page
			$page_data = $body;
		}
	}
	
	if(!$forward){
		page_draw($title_text, elgg_view_layout("two_column_left_sidebar", "", $page_data));
	} else {
		forward(REFERER);
	}
?>