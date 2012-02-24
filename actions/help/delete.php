<?php 

	admin_gatekeeper();
	
	$guid = (int) get_input("guid", 0);
	
	if(!empty($guid) && ($entity = get_entity($guid))){
		if($entity->getSubtype() == UserSupportHelp::SUBTYPE){
			if($entity->delete()){
				system_message(elgg_echo("user_support:action:help:delete:success"));
			} else {
				register_error(elgg_echo("user_support:action:help:delete:error:delete"));
			}
		} else {
			register_error(elgg_echo("user_support:action:help:delete:error:subtype"));	
		}
	} else {
		register_error(elgg_echo("user_support:action:help:delete:error:input"));
	}

	forward(REFERER);

?>