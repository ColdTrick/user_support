<?php 

	admin_gatekeeper();
	
	$guid = (int) get_input("guid");
	
	$forward_url = REFERER;
	
	if(!empty($guid)){
		if(($ticket = get_entity($guid)) && elgg_instanceof($ticket, "object", UserSupportTicket::SUBTYPE, "UserSupportTicket")){
			if($ticket->canEdit()) {
				if($ticket->delete()){
					$forward_url = "pg/user_support/support_ticket/mine";
					system_message(elgg_echo("user_support:action:ticket:delete:success"));
				} else {
					register_error(elgg_echo("user_support:action:ticket:delete:error:delete"));
				}
			} else {
				register_error(elgg_echo("InvalidParameterException:NoEntityFound"));
			}
		} else {
			register_error(elgg_echo("InvalidClassException:NotValidElggStar", array($guid, "UserSupportTicket")));
		}
	} else {
		register_error(elgg_echo("InvalidParameterException:MissingParameter"));
	}
	
	forward($forward_url);
	