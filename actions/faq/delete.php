<?php 

	$guid = (int) get_input("guid", 0);
	
	$forward_url = REFERER;
	
	if(!empty($guid) && ($entity = get_entity($guid))){
		if(elgg_instanceof($entity, "object", UserSupportFAQ::SUBTYPE, "UserSupportFAQ")){
			if($entity->delete()){
				$forward_url = "user_support/faq";
				
				system_message(elgg_echo("user_support:action:faq:delete:success"));
			} else {
				register_error(elgg_echo("user_support:action:faq:delete:error:delete"));
			}
		} else {
			register_error(elgg_echo("InvalidClassException:NotValidElggStar", array($guid, "UserSupportFAQ")));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
	}

	forward($forward_url);
	