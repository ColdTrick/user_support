<?php 

	admin_gatekeeper();
	
	$guid = (int) get_input("guid");
	
	$user = get_loggedin_user();
	
	if(!empty($guid) && ($entity = get_entity($guid))){
		if($entity->getSubtype() == UserSupportTicket::SUBTYPE){
			create_annotation($entity->getGUID(), 
								'generic_comment',
								elgg_echo("user_support:support_ticket:closed"), 
								"", 
								$user->getGUID(), 
								$entity->access_id);
								
			if($entity->setStatus(UserSupportTicket::CLOSED)){
				notify_user($entity->getOwner(),
					$user->getGUID(),
					elgg_echo('generic_comment:email:subject'),
					sprintf(
						elgg_echo('generic_comment:email:body'),
						$entity->title,
						$user->name,
						elgg_echo("user_support:support_ticket:closed"),
						$entity->getURL(),
						$user->name,
						$user->getURL()
					)
				);
				
				system_message(elgg_echo("user_support:action:ticket:close:success"));
			} else {
				register_error(elgg_echo("user_support:action:ticket:close:error:disable"));
			}
		} else {
			register_error(elgg_echo("user_support:action:ticket:close:error:subtype"));
		}
	} else {
		register_error(elgg_echo("user_support:action:ticket:close:error:input"));
	}

	forward("pg/user_support/support_ticket");


?>