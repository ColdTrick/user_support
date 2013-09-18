<?php

	gatekeeper();
	
	$guid = (int) get_input("guid");
	
	$forward = true;
	
	if (($entity = get_entity($guid)) && elgg_instanceof($entity, "object", UserSupportTicket::SUBTYPE, "UserSupportTicket")) {
		if ($entity->canEdit()) {
			$forward = false;
			
			elgg_set_page_owner_guid($entity->getOwnerGUID());
			
			$title_text = $entity->title;
			
			$page_data = elgg_view_layout("content", array(
				"title" => $title_text,
				"content" => elgg_view_form("user_support/support_ticket/edit", array(), array("entity" => $entity)),
				"filter" => ""
			));
		}
	}

	if(!$forward){
		echo elgg_view_page($title_text, $page_data);
	} else {
		forward(REFERER);
	}
	