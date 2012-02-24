<?php 

	gatekeeper();
	
	$guid = (int) get_input("guid");
	
	$forward = true;
	
	if($entity = get_entity($guid)){
		if(($entity instanceof UserSupportTicket) && $entity->canEdit()){
			set_page_owner($entity->getOwner());
			
			$forward = false;
			
			$title_text = $entity->title;
			$title = elgg_view_title($title_text);
			
			$body = elgg_view("user_support/forms/support_ticket", array("entity" => $entity));
			$body = elgg_view("page_elements/contentwrapper", array("body" => $body));
			
			$page_data = $title . $body;
		}
	}

	if(!$forward){
		page_draw($title_text, elgg_view_layout("two_column_left_sidebar", "", $page_data));
	} else {
		forward(REFERER);
	}

?>