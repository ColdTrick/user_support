<?php 

	admin_gatekeeper();
	
	$guid = (int) get_input("guid");
	
	$user = get_loggedin_user();

	if(!empty($guid) && ($entity = get_entity($guid))){
		if($entity->getSubtype() == UserSupportTicket::SUBTYPE){
			create_annotation($entity->getGUID(), 
								'generic_comment',
								elgg_echo("user_support:support_ticket:reopened"), 
								"", 
								$user->getGUID(), 
								$entity->access_id);
			
			if($entity->setStatus(UserSupportTicket::OPEN)){
				notify_user($entity->getOwner(),
					$user->getGUID(),
					elgg_echo('generic_comment:email:subject'),
					sprintf(
						elgg_echo('generic_comment:email:body'),
						$entity->title,
						$user->name,
						elgg_echo("user_support:support_ticket:reopened"),
						$entity->getURL(),
						$user->name,
						$user->getURL()
					)
				);
				
				system_message(elgg_echo("user_support:action:ticket:reopen:success"));
			} else {
				register_error(elgg_echo("user_support:action:ticket:reopen:error:enable"));
			}
		} else {
			register_error(elgg_echo("user_support:action:ticket:reopen:error:subtype"));
		}
	} else {
		register_error(elgg_echo("user_support:action:ticket:reopen:error:input"));
	}
	
	forward(REFERER);

?>