<?php 

	admin_gatekeeper();
	
	$guid = (int) get_input("guid");
	
	if(!empty($guid)){
		if(($ticket = get_entity($guid)) && ($ticket instanceof UserSupportTicket)){
			if($ticket->canEdit()) {
				if($ticket->delete()){
					system_message(elgg_echo("user_support:action:ticket:delete:success"));
				} else {
					register_error(elgg_echo("user_support:action:ticket:delete:error:delete"));
				}
			} else {
				register_error(elgg_echo("user_support:action:ticket:delete:error:can_edit"));
			}
		} else {
			register_error(elgg_echo("user_support:action:ticket:delete:error:entity"));
		}
	} else {
		register_error(elgg_echo("user_support:action:ticket:delete:error:input"));
	}
	
	forward(REFERER);

?>