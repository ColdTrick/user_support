<?php 

	// load classes
	require_once(dirname(__FILE__) . "/classes/UserSupportFAQ.php");
	require_once(dirname(__FILE__) . "/classes/UserSupportHelp.php");
	require_once(dirname(__FILE__) . "/classes/UserSupportTicket.php");

	// load helper functions
	require_once(dirname(__FILE__) . "/lib/functions.php");
	require_once(dirname(__FILE__) . "/lib/events.php");
	
	function user_support_init(){
		// extend css & js
		elgg_extend_view("css", "user_support/css");
		elgg_extend_view("css", "fancybox/css");
		elgg_extend_view("js/initialise_elgg", "user_support/js");
		elgg_extend_view("metatags", "user_support/metatags");
		
		
		// extend header
		elgg_extend_view("page_elements/header_contents", "user_support/button");
		
		// register page handler for nice URL's
		register_page_handler("user_support", "user_support_page_handler");
		
		// register subtype handlers
		add_subtype("object", UserSupportFAQ::SUBTYPE, "UserSupportFAQ");
		add_subtype("object", UserSupportHelp::SUBTYPE, "UserSupportHelp");
		add_subtype("object", UserSupportTicket::SUBTYPE, "UserSupportTicket");
		
		// register subtypes for search
		register_entity_type("object", UserSupportFAQ::SUBTYPE);
		register_entity_type("object", UserSupportHelp::SUBTYPE);
		
		// update class for FAQ, since user_support v1.0
		if(!get_subtype_class("object", UserSupportFAQ::SUBTYPE)){
			run_function_once("user_support_faq_class_update");
		}
	}
	
	function user_support_pagesetup(){
		global $CONFIG;
		
		$user = get_loggedin_user();
		$page_owner = page_owner_entity();
		$context = get_context();
		
		// add tools menu
		add_menu(elgg_echo("user_support:menu:faq"), $CONFIG->wwwroot . "pg/user_support/faq");
		
		if(isloggedin()){
			add_menu(elgg_echo("user_support:menu:support_tickets:mine"), $CONFIG->wwwroot . "pg/user_support/support_ticket/mine");
		}
		
		if(isadminloggedin()){
			// main menu items
			if(($context == "admin" || $context == "user_support")){
				add_submenu_item(elgg_echo("user_support:menu:support_tickets"), $CONFIG->wwwroot . "pg/user_support/support_ticket", "user_support_admin");
			}
			
			if($context == "user_support"){
				add_submenu_item(elgg_echo("user_support:menu:faq:create"), $CONFIG->wwwroot . "pg/user_support/faq/edit/", "faq");
				
				add_submenu_item(elgg_echo("user_support:menu:support_tickets:archive"), $CONFIG->wwwroot . "pg/user_support/support_ticket/archive", "user_support_admin");
			}
		}
		
		if($context == "user_support"){
			add_submenu_item(elgg_echo("user_support:menu:faq"), $CONFIG->wwwroot . "pg/user_support/faq", "faq");
			
			if(isloggedin()){
				add_submenu_item(elgg_echo("user_support:menu:support_tickets:mine"), $CONFIG->wwwroot . "pg/user_support/support_ticket/mine", "user_support");
				add_submenu_item(elgg_echo("user_support:menu:support_tickets:mine:archive"), $CONFIG->wwwroot . "pg/user_support/support_ticket/mine/archive", "user_support");
			}
		}
	}
	
	function user_support_page_handler($page){
		
		switch($page[0]){
			case "help":
				switch($page[1]){
					case "edit":
						if(!empty($page[2]) && is_numeric($page[2])){
							set_input("guid", $page[2]);
						}
						include(dirname(__FILE__) . "/pages/help/edit.php");
						break;
					default:
						if(!empty($page[1]) && is_numric($page[1])){
							
						} else {
							include(dirname(__FILE__) . "/pages/support_ticket/list.php");
						}
						break;
				}
				break;
			case "faq":
				switch($page[1]){
					case "edit":
						if(!empty($page[2]) && is_numeric($page[2])){
							set_input("guid", $page[2]);
						}
						include(dirname(__FILE__) . "/pages/faq/edit.php");
						break;
					default:
						if(!empty($page[1]) && is_numeric($page[1])){
							set_input("guid", $page[1]);
							include(dirname(__FILE__) . "/pages/faq/view.php");
						} else {
							include(dirname(__FILE__) . "/pages/faq/list.php");
						}
						break;
				}
				break;
			case "support_ticket":
				switch($page[1]){
					case "edit":
						if(!empty($page[2]) && is_numeric($page[2])){
							set_input("guid", $page[2]);
						}
						include(dirname(__FILE__) . "/pages/support_ticket/edit.php");
						break;
					case "archive":
						include(dirname(__FILE__) . "/pages/support_ticket/archive.php");
						break;
					case "mine":
						if(!empty($page[2]) && ($page[2] == "archive")){
							set_input("status", UserSupportTicket::CLOSED);
						}
						include(dirname(__FILE__) . "/pages/support_ticket/mine.php");
						break;
					default:
						if(!empty($page[1]) && is_numeric($page[1])){
							set_input("guid", $page[1]);
							include(dirname(__FILE__) . "/pages/support_ticket/view.php");
						} else {
							include(dirname(__FILE__) . "/pages/support_ticket/list.php");
						}
						break;
				}
				break;
			case "help_center":
				include(dirname(__FILE__) . "/pages/help_center.php");
				break;
			case "search":
				include(dirname(__FILE__) . "/procedures/search.php");
				break;
			default:
				return false;
				break;
		}
	}
	
	/**
	 * This function adds a class handler to object->faq
	 * Since the old FAQ didn't had a class
	 * 
	 * @return bool
	 */
	function user_support_faq_class_update(){
		global $CONFIG;
		
		$sql = "UPDATE " . $CONFIG->dbprefix . "entity_subtypes";
		$sql .= " SET class = 'UserSupportFAQ'";
		$sql .= " WHERE type='object' AND subtype='" . UserSupportFAQ::SUBTYPE . "'";
		
		return update_data($sql);
	}

	// register default Elgg events
	register_elgg_event_handler("init", "system", "user_support_init");
	register_elgg_event_handler("pagesetup", "system", "user_support_pagesetup");

	// register other events
	register_elgg_event_handler("create", "annotation", "user_support_create_annotation_event");
	register_elgg_event_handler("create", "object", "user_support_create_object_event");
	
	// register actions
	register_action("user_support/help/edit", false, dirname(__FILE__) . "/actions/help/edit.php", true);
	register_action("user_support/help/delete", false, dirname(__FILE__) . "/actions/help/delete.php", true);
	
	register_action("user_support/ticket/edit", false, dirname(__FILE__) . "/actions/ticket/edit.php");
	register_action("user_support/ticket/delete", false, dirname(__FILE__) . "/actions/ticket/delete.php", true);
	register_action("user_support/ticket/close", false, dirname(__FILE__) . "/actions/ticket/close.php", true);
	register_action("user_support/ticket/reopen", false, dirname(__FILE__) . "/actions/ticket/reopen.php", true);
	
	register_action("user_support/faq/edit", false, dirname(__FILE__) . "/actions/faq/edit.php", true);
	register_action("user_support/faq/delete", false, dirname(__FILE__) . "/actions/faq/delete.php", true);

?>