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
					
					// notify admins about update
					if($admins = user_support_get_admin_notify_users($entity)){
						$subject = elgg_echo("user_support:notify:admin:updated:subject");
						$message = sprintf(elgg_echo("user_support:notify:admin:updated:message"),
											$entity->getOwnerEntity()->name,
											$entity->title,
											$annotation->value,
											$entity->getURL()
						);
						
						foreach($admins as $admin){
							notify_user($admin->getGUID(), $entity->getOwner(), $subject, $message);
						}
					}
				}
				
				$entity->save();
			}
		}
	}

	function user_support_create_object_event($event, $type, $object){
		global $CONFIG;
		
		if(!empty($object) && ($object instanceof UserSupportTicket)){
			
			if($users = user_support_get_admin_notify_users($object)){
				$subject = elgg_echo("user_support:notify:admin:create:subject");
				$message = sprintf(elgg_echo("user_support:notify:admin:create:message"),
										$object->getOwnerEntity()->name,
										$object->description,
										$object->getURL()
				);
				
				foreach($users as $user){
					notify_user($user->getGUID(), $object->getOwner(), $subject, $message);
				}
			}
		}
	}


?>