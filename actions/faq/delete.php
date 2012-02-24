<?php 

	global $CONFIG;

	admin_gatekeeper();
	
	$guid = (int) get_input("guid", 0);
	
	$forward_url = REFERER;
	
	if(!empty($guid) && ($entity = get_entity($guid))){
		if($entity->getSubtype() == UserSupportFAQ::SUBTYPE){
			if($entity->delete()){
				$forward_url = $CONFIG->wwwroot . "pg/user_support/faq";
				
				system_message(elgg_echo("user_support:action:faq:delete:success"));
			} else {
				register_error(elgg_echo("user_support:action:faq:delete:error:delete"));
			}
		} else {
			register_error(elgg_echo("user_support:action:faq:delete:error:entity"));
		}
	} else {
		register_error(elgg_echo("user_support:action:faq:delete:error:input"));
	}

	forward($forward_url);
?>