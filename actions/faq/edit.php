<?php 

	$guid = (int) get_input("guid", 0);
	$title = get_input("title");
	$desc = get_input("description");
	$access_id = (int) get_input("access_id", ACCESS_PRIVATE);
	$tags = string_to_tag_array(get_input("tags"));
	$comments = get_input("allow_comments");
	$help_context = get_input("help_context");

	$forward_url = REFERER;
	
	if(!empty($title) && !empty($desc)){
		if(!empty($guid) && ($entity = get_entity($guid))){
			if(!elgg_instanceof($entity, "object", UserSupportFAQ::SUBTYPE, "UserSupportFAQ")){
				$entity = null;
				register_error(elgg_echo("InvalidClassException:NotValidElggStar", array($guid, "UserSupportFAQ")));
			}
		} else {
			$entity = new UserSupportFAQ();
			
			if(!$entity->save()){
				$entity = null;
				register_error(elgg_echo("IOException:UnableToSaveNew", array("UserSupportFAQ")));
			}
		}
		
		if(!empty($entity)){
			$entity->title = $title;
			$entity->description = $desc;
			$entity->access_id = $access_id;
			
			$entity->tags = $tags;
			$entity->allow_comments = $comments;
			
			if(elgg_is_admin_logged_in()){
				$entity->help_context = $help_context;
			}
			
			if($entity->save()){
				$forward_url = $entity->getURL();
				system_message(elgg_echo("user_support:action:faq:edit:success"));
			} else {
				register_error(elgg_echo("user_support:action:faq:edit:error:save"));
			}
		}
	} else {
		register_error(elgg_echo("user_support:action:faq:edit:error:input"));
	}

	forward($forward_url);
