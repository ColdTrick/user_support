<?php

	// load helper functions
	require_once(dirname(__FILE__) . "/lib/events.php");
	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/hooks.php");
	require_once(dirname(__FILE__) . "/lib/page_handlers.php");
	require_once(dirname(__FILE__) . "/lib/run_once.php");
	
	// register default Elgg events
	elgg_register_event_handler("init", "system", "user_support_init");
	elgg_register_event_handler("pagesetup", "system", "user_support_pagesetup");
	
	function user_support_init(){
		// extend css
		elgg_extend_view("css/elgg", "css/user_support/site");
		elgg_extend_view("css/admin", "css/user_support/admin");

		elgg_extend_view("js/elgg", "js/user_support/site");
		
		elgg_extend_view("page/elements/footer", "user_support/button");
		
		// register page handler for nice URL's
		elgg_register_page_handler("user_support", "user_support_page_handler");
		
		// register subtype handlers
		add_subtype("object", UserSupportFAQ::SUBTYPE, "UserSupportFAQ");
		add_subtype("object", UserSupportHelp::SUBTYPE, "UserSupportHelp");
		add_subtype("object", UserSupportTicket::SUBTYPE, "UserSupportTicket");
		
		// register subtypes for search
		elgg_register_entity_type("object", UserSupportFAQ::SUBTYPE);
		elgg_register_entity_type("object", UserSupportHelp::SUBTYPE);
		
		// update class for FAQ, since user_support v1.0
		if (!get_subtype_class("object", UserSupportFAQ::SUBTYPE)) {
			run_function_once("user_support_faq_class_update");
		}
		
		// add a group tool option for FAQ
		add_group_tool_option("faq", elgg_echo("user_support:group:tool_option"), false);
		
		// register events
		elgg_register_event_handler("create", "annotation", "user_support_create_annotation_event");
		elgg_register_event_handler("create", "object", "user_support_create_object_event");
		
		// plugin hooks
		elgg_register_plugin_hook_handler("register", "menu:entity", "user_support_entity_menu_hook", 550);
		elgg_register_plugin_hook_handler("register", "menu:owner_block", "user_support_owner_block_menu_hook");
		elgg_register_plugin_hook_handler("register", "menu:title", "user_support_title_menu_hook");
		
		// register actions
		elgg_register_action("user_support/help/edit", dirname(__FILE__) . "/actions/help/edit.php", "admin");
		elgg_register_action("user_support/help/delete", dirname(__FILE__) . "/actions/help/delete.php", "admin");
		
		elgg_register_action("user_support/support_ticket/edit", dirname(__FILE__) . "/actions/ticket/edit.php");
		elgg_register_action("user_support/support_ticket/delete", dirname(__FILE__) . "/actions/ticket/delete.php", "admin");
		elgg_register_action("user_support/support_ticket/close", dirname(__FILE__) . "/actions/ticket/close.php", "admin");
		elgg_register_action("user_support/support_ticket/reopen", dirname(__FILE__) . "/actions/ticket/reopen.php", "admin");
		
		elgg_register_action("user_support/faq/edit", dirname(__FILE__) . "/actions/faq/edit.php", "admin");
		elgg_register_action("user_support/faq/delete", dirname(__FILE__) . "/actions/faq/delete.php", "admin");
		
	}
	
	function user_support_pagesetup(){
		
		// site (topbar) menu
		elgg_register_menu_item("site", array(
			"name" => "faq",
			"text" => elgg_echo("user_support:menu:faq"),
			"href" => "user_support/faq"
		));
		
		//page (side) menu
		elgg_register_menu_item("page", array(
			"name" => "faq",
			"text" => elgg_echo("user_support:menu:faq"),
			"href" => "user_support/faq",
			"context" => "user_support"
		));
		
		if (elgg_is_logged_in()) {
			// site (topbar) menu
			elgg_register_menu_item("site", array(
				"name" => "support_ticket_mine",
				"text" => elgg_echo("user_support:menu:support_tickets:mine"),
				"href" => "user_support/support_ticket/mine"
			));
			
			// page (side) menu
			elgg_register_menu_item("page", array(
				"name" => "support_ticket_mine",
				"text" => elgg_echo("user_support:menu:support_tickets:mine"),
				"href" => "user_support/support_ticket/mine",
				"context" => "user_support"
			));
			
			// filter menu
			elgg_register_menu_item("user_support", array(
				"name" => "mine",
				"text" => elgg_echo("user_support:menu:support_tickets:mine"),
				"href" => "user_support/support_ticket/mine",
				"context" => "user_support"
			));
			elgg_register_menu_item("user_support", array(
				"name" => "my_archive",
				"text" => elgg_echo("user_support:menu:support_tickets:mine:archive"),
				"href" => "user_support/support_ticket/mine/archive",
				"context" => "user_support"
			));
			
			// admin menu items
			if (elgg_is_admin_logged_in()) {
				// filter menu
				elgg_register_menu_item("user_support", array(
					"name" => "all",
					"text" => elgg_echo("user_support:menu:support_tickets"),
					"href" => "user_support/support_ticket",
					"context" => "user_support"
				));
				elgg_register_menu_item("user_support", array(
					"name" => "archive",
					"text" => elgg_echo("user_support:menu:support_tickets:archive"),
					"href" => "user_support/support_ticket/archive",
					"context" => "user_support"
				));
				
			}
		}
	}
	
