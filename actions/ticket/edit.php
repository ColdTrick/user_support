<?php 

	global $CONFIG;
	
	gatekeeper();
	
	$guid = (int) get_input("guid");
	$title = get_input("title");
	$help_url = get_input("help_url");
	$help_context = get_input("help_context");
	$tags = string_to_tag_array(get_input("tags"));
	$support_type = get_input("support_type");
	
	$forward_url = REFERER;
	
	$loggedin_user = get_loggedin_user();
	
	if(!empty($title) && !empty($support_type)){
		if(!empty($guid)){
			if($ticket = get_entity($guid)){
				if(!($ticket instanceof UserSupportTicket)){
					register_error(elgg_echo("user_support:action:ticket:edit:error:entity"));
					unset($ticket);
				}
			}
		} else {
			$ticket = new UserSupportTicket();
			
			if(!$ticket->save()){
				register_error(elgg_echo("user_support:action:ticket:edit:error:create"));
				unset($ticket);
			}
		}
		
		if(!empty($ticket)){
			$ticket->title = $title;
			
			$ticket->help_url = $help_url;
			$ticket->help_context = $help_context;
			$ticket->tags = $tags;
			$ticket->support_type = $support_type;
			
			if($ticket->save()){
				if(!empty($guid)){
					$forward_url = $ticket->getURL();
				}
				system_message(elgg_echo("user_support:action:ticket:edit:success"));
			} else {
				register_error(elgg_echo("user_support:action:ticket:edit:error:save"));
			}
		}
	} else {
		register_error(elgg_echo("user_support:action:ticket:edit:error:input"));
	}

	forward($forward_url);

?>