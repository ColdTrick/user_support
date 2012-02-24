<?php 

	admin_gatekeeper();
	
	set_page_owner(get_loggedin_userid());
	
	$guid = (int) get_input("guid");
	if(!empty($guid) && ($entity = get_entity($guid))){
		if($entity->getSubtype() != UserSupportFAQ::SUBTYPE){
			$entity = null;
		} else {
			$title_text = elgg_echo("user_support:faq:edit:title:edit");
		}
	}

	if(empty($title_text)){
		$title_text = elgg_echo("user_support:faq:edit:title:create");
	}
	
	$help_context = user_support_find_unique_help_context();

	// build page elements
	$title = elgg_view_title($title_text);
	
	$form = elgg_view("user_support/forms/faq", array("entity" => $entity, "help_context" => $help_context));
	
	// build page
	$page_data = $title . $form;
	
	// draw page
	page_draw($title_text, elgg_view_layout("two_column_left_sidebar", "", $page_data));

?>