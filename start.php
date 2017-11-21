<?php

// load helper functions
require_once(dirname(__FILE__) . "/lib/functions.php");
require_once(dirname(__FILE__) . "/lib/hooks.php");
require_once(dirname(__FILE__) . "/lib/page_handlers.php");

// register default Elgg events
elgg_register_event_handler("init", "system", "user_support_init");

/**
 * Gets called during system init
 *
 * @return void
 */
function user_support_init() {
	// extend css
	elgg_extend_view("css/elgg", "css/user_support/site");
	elgg_extend_view("css/admin", "css/user_support/admin");

	elgg_extend_view("js/elgg", "js/user_support/site");
	
	elgg_extend_view("page/elements/footer", "user_support/button");
	
	elgg_extend_view("forms/comment/save", "user_support/support_ticket/comment");
	
	// register page handler for nice URL's
	elgg_register_page_handler("user_support", "user_support_page_handler");
	
	// register subtypes for search
	elgg_register_entity_type("object", UserSupportFAQ::SUBTYPE);
	elgg_register_entity_type("object", UserSupportHelp::SUBTYPE);
	
	// register notifications
	elgg_register_notification_event("object", "comment");
	elgg_register_plugin_hook_handler("get", "subscriptions", "user_support_get_subscriptions_support_ticket_comment_hook");
	elgg_register_plugin_hook_handler("prepare", "notification:create:object:comment", "user_support_prepare_support_ticket_comment_message_hook");
	
	elgg_register_notification_event("object", UserSupportTicket::SUBTYPE);
	elgg_register_plugin_hook_handler("get", "subscriptions", "user_support_get_subscriptions_support_ticket_hook");
	elgg_register_plugin_hook_handler("prepare", "notification:create:object:" . UserSupportTicket::SUBTYPE, "user_support_prepare_support_ticket_message_hook");
	
	// add a group tool option for FAQ
	add_group_tool_option("faq", elgg_echo("user_support:group:tool_option"), false);
	elgg_extend_view("groups/tool_latest", "user_support/faq/group_module");
	
	// register widgets
	elgg_register_widget_type("faq", elgg_echo("user_support:widgets:faq:title"), elgg_echo("user_support:widgets:faq:description"), array("groups"));
	elgg_register_widget_type("support_ticket", elgg_echo("user_support:widgets:support_ticket:title"), elgg_echo("user_support:widgets:support_ticket:description"), array("dashboard"), true);
	if (user_support_staff_gatekeeper(false)) {
		elgg_register_widget_type("support_staff", elgg_echo("user_support:widgets:support_staff:title"), elgg_echo("user_support:widgets:support_staff:description"), array("dashboard", "admin"));
	}
	
	// register events
	elgg_register_event_handler("create", "object", "\ColdTrick\UserSupport\Comments::supportTicketStatus");
	
	elgg_register_event_handler('upgrade', 'system', '\ColdTrick\UserSupport\Upgrade::setFAQClass');
	elgg_register_event_handler('upgrade', 'system', '\ColdTrick\UserSupport\Upgrade::setHelpClass');
	elgg_register_event_handler('upgrade', 'system', '\ColdTrick\UserSupport\Upgrade::setTicketClass');
	
	// plugin hooks
	elgg_register_plugin_hook_handler("register", "menu:entity", "\ColdTrick\UserSupport\Menus\Entity::registerTicket");
	elgg_register_plugin_hook_handler("register", "menu:entity", "\ColdTrick\UserSupport\Menus\Entity::registerHelp");
	elgg_register_plugin_hook_handler("register", "menu:owner_block", "user_support_owner_block_menu_hook");
	elgg_register_plugin_hook_handler("register", "menu:title", "user_support_title_menu_hook");
	elgg_register_plugin_hook_handler("register", "menu:site", "user_support_site_menu_hook");
	elgg_register_plugin_hook_handler("register", "menu:page", "user_support_page_menu_hook");
	elgg_register_plugin_hook_handler("register", "menu:footer", "user_support_footer_menu_hook");
	elgg_register_plugin_hook_handler("register", "menu:user_hover", "user_support_user_hover_menu_hook");
	elgg_register_plugin_hook_handler("register", "menu:user_support", "user_support_user_support_menu_hook");
	elgg_register_plugin_hook_handler("register", "menu:annotation", "user_support_annotation_menu_hook");
	
	elgg_register_plugin_hook_handler("widget_url", "widget_manager", "user_support_widget_url_hook");
	
	elgg_register_plugin_hook_handler("permissions_check", "object", "user_support_permissions_check_hook");
	
	// register actions
	elgg_register_action("user_support/help/edit", dirname(__FILE__) . "/actions/help/edit.php", "admin");
	elgg_register_action("user_support/help/delete", dirname(__FILE__) . "/actions/help/delete.php", "admin");
	
	elgg_register_action("user_support/support_ticket/edit", dirname(__FILE__) . "/actions/ticket/edit.php");
	elgg_register_action("user_support/support_ticket/delete", dirname(__FILE__) . "/actions/ticket/delete.php");
	elgg_register_action("user_support/support_ticket/close", dirname(__FILE__) . "/actions/ticket/close.php");
	elgg_register_action("user_support/support_ticket/reopen", dirname(__FILE__) . "/actions/ticket/reopen.php");
	
	elgg_register_action("user_support/faq/edit", dirname(__FILE__) . "/actions/faq/edit.php");
	elgg_register_action("user_support/faq/delete", dirname(__FILE__) . "/actions/faq/delete.php");
	
	elgg_register_action("user_support/support_staff", dirname(__FILE__) . "/actions/support_staff.php", "admin");
}
