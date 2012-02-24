<?php 

	function user_support_create_annotation_event($event, $type, $annotation){
		
		if(!empty($annotation) && ($annotation instanceof ElggAnnotation)){
			$entity = get_entity($annotation->entity_guid);
			$user = get_user($annotation->owner_guid);
			
			if(!empty($entity) && ($entity instanceof UserSupportTicket) && !empty($user)){
				if($user->getGUID() != $entity->getOwner()){
					// user is not owner and is admin, so close ticket
					if(get_plugin_Setting("auto_close_tickets", "user_support") == "yes"){
						$entity->setStatus(UserSupportTicket::CLOSED);
					}
				} elseif($user->getGUID() == $entity->getOwner()){
					// user is the owner, so reopen
					$entity->setStatus(UserSupportTicket::OPEN);
				}
				
				$entity->save();
			}
		}
	}




?>