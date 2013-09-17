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
	
	/**
	 * Adds items to site menu
	 *
	 * @param unknown_type $hook
	 * @param unknown_type $type
	 * @param unknown_type $return_value
	 * @param unknown_type $params
	 * @return Ambigous <ElggMenuItem, NULL>
	 */
	function user_support_site_menu_hook($hook, $type, $return_value, $params) {
		$result = $return_value;
		
		if (elgg_get_plugin_setting("add_faq_site_menu_item", "user_support") != "no") {
			$result[] = ElggMenuItem::factory(array(
				"name" => "faq",
				"text" => elgg_echo("user_support:menu:faq"),
				"href" => "user_support/faq"
			));
		}
		
		if (elgg_is_logged_in()) {
			$result[] = ElggMenuItem::factory(array(
				"name" => "support_ticket_mine",
				"text" => elgg_echo("user_support:menu:support_tickets:mine"),
				"href" => "user_support/support_ticket/mine"
			));
		}
		
		return $result;
	}

	/**
	 * Adds items to page menu
	 *
	 * @param unknown_type $hook
	 * @param unknown_type $type
	 * @param unknown_type $return_value
	 * @param unknown_type $params
	 * @return Ambigous <ElggMenuItem, NULL>
	 */
	function user_support_page_menu_hook($hook, $type, $return_value, $params) {
		$result = $return_value;
		
		$result[] = ElggMenuItem::factory(array(
			"name" => "faq",
			"text" => elgg_echo("user_support:menu:faq"),
			"href" => "user_support/faq",
			"context" => "user_support"
		));
		
		if (elgg_is_logged_in()) {
			$result[] = ElggMenuItem::factory(array(
				"name" => "support_ticket_mine",
				"text" => elgg_echo("user_support:menu:support_tickets:mine"),
				"href" => "user_support/support_ticket/mine",
				"context" => "user_support"
			));
		}
		
		return $result;
	}
	
	function user_support_owner_block_menu_hook($hook, $type, $return_value, $params) {
		$result = $return_value;
		
		if (!empty($params) && is_array($params)) {
			$group = elgg_extract("entity", $params);
			
			if (elgg_instanceof($group, "group")) {
				if ($group->faq_enable == "yes") {
					$result[] = ElggMenuItem::factory(array(
						"name" => "faq",
						"text" => elgg_echo("user_support:menu:faq:group"),
						"href" => "user_support/faq/group/" . $group->getGUID() . "/all"
					));
				}
			}
		}
		
		return $result;
	}
	
	function user_support_title_menu_hook($hook, $type, $return_value, $params) {
		$result = $return_value;
		
		if (elgg_in_context("faq")) {
			$user = elgg_get_logged_in_user_entity();
			$page_owner = elgg_get_page_owner_entity();
			
			if (!empty($user) && ($user->isAdmin() || (!empty($page_owner) && elgg_instanceof($page_owner, "group") && $page_owner->canEdit()))) {
				$container_guid = elgg_get_site_entity()->getGUID();
				
				if (!empty($page_owner) && elgg_instanceof($page_owner, "group")) {
					$container_guid = $page_owner->getGUID();
				}
				
				$result[] = ElggMenuItem::factory(array(
					"name" => "add",
					"text" => elgg_echo("user_support:menu:faq:create"),
					"href" => "user_support/faq/add/" . $container_guid,
					"class" => "elgg-button elgg-button-action"
				));
			}
		}
		
		return $result;
	}
	
	function user_support_widget_url_hook($hook, $type, $return_value, $params) {
		$result = $return_value;
		
		if (!$result && !empty($params) && is_array($params)) {
			$entity = elgg_extract("entity", $params);
			
			if (!empty($entity) && elgg_instanceof($entity, "object", "widget")) {
				switch ($entity->handler) {
					case "faq":
						$owner = $entity->getOwnerEntity();
						$link = "user_support/faq";
						if (elgg_instanceof($owner, "group")) {
							$link .= "/group/" . $owner->getGUID() . "/all";
						}
						
						$result = $link;
						
						break;
				}
			}
		}
		
		return $result;
	}
	
