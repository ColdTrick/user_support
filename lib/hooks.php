<?php

	function user_support_entity_menu_hook($hook, $type, $return_value, $params){
		$result = $return_value;
		
		if(!empty($params) && is_array($params)){
			$entity = elgg_extract("entity", $params);
			
			if(!empty($entity)){
				if(elgg_instanceof($entity, "object", UserSupportTicket::SUBTYPE, "UserSupportTicket")){
					if(elgg_is_admin_logged_in()){
						if($entity->getStatus() == UserSupportTicket::OPEN){
							$result[] = ElggMenuItem::factory(array(
								"name" => "status",
								"text" => elgg_echo("close"),
								"href" => "action/user_support/support_ticket/close?guid=" . $entity->getGUID(),
								"is_action" => true,
								"priority" => 200
							));
						} else {
							$result[] = ElggMenuItem::factory(array(
								"name" => "status",
								"text" => elgg_echo("user_support:reopen"),
								"href" => "action/user_support/support_ticket/reopen?guid=" . $entity->getGUID(),
								"is_action" => true,
								"priority" => 200
							));
						}
					}
				} elseif(elgg_instanceof($entity, "object", UserSupportHelp::SUBTYPE, "UserSupportHelp")){
					// cleanup all menu items
					foreach($result as $index => $menu_item){
						if($menu_item->getName() != "delete"){
							unset($result[$index]);
						}
					}
					// user_support_help_edit_form_wrapper
					$result[] = ElggMenuItem::factory(array(
						"name" => "edit",
						"text" => elgg_echo("edit"),
						"href" => "#user_support_help_edit_form_wrapper",
						"rel" => "toggle",
						"priority" => 200
					));
				}
			}
		}
		
		return $result;
	}