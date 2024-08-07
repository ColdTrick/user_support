<?php

return array(

	'user_support' => "User Support",

	// objects
	'item:object:faq' => "User support FAQ",
	'item:object:help' => "User support Contextual help",
	'item:object:support_ticket' => "User support Ticket",

	'collection:object:faq' => "User support FAQs",
	'collection:object:help' => "User support Contextual help",
	'collection:object:support_ticket' => "User support Tickets",

	'input:container_guid:object:faq:info' => "This User support FAQ will be posted in %s",
	
	// general
	'user_support:support_type' => "Category",
	'user_support:support_type:question' => "Question",
	'user_support:support_type:bug' => "Bug",
	'user_support:support_type:request' => "Feature request",

	'user_support:support_type:status:open' => "Open",
	'user_support:support_type:status:closed' => "Closed",
	
	'user_support:anwser' => "Answer",
	'user_support:question' => "Question",
	'user_support:url' => "URL",
	'user_support:url:info' => "This ticket has been created %shere%s.",
	'user_support:allow_comments' => "Allow comments",
	'user_support:read_more' => "Read more",
	'user_support:help_context' => "Contextual help",
	'user_support:help_context:help' => "Select a help context where this FAQ applies, when selected this FAQ will be shown in the Help center on that page.",
	'user_support:reopen' => "Reopen",
	'user_support:comment_close' => "Comment and close",

	'user_support:staff_gatekeeper' => "This page is only available for support staff",
	
	// settings
	'user_support:settings:support_tickets:title' => "Support Tickets Settings",
	'user_support:settings:support_tickets:help_group' => "Select a group for users to ask for help",
	
	'user_support:settings:help:title' => "Contextual Help Settings",
	'user_support:settings:help:enabled' => "Is contextual help enabled?",

	'user_support:settings:help_center:title' => "Help Center Settings",
	'user_support:settings:help_center:add_help_center_site_menu_item' => "Add a site menu item for the Help Center",
	'user_support:settings:help_center:show_floating_button' => "Show a floating button which links to the Help Center",
	'user_support:settings:help_center:show_floating_button:left_top' => "Left - Top",
	'user_support:settings:help_center:show_floating_button:left_bottom' => "Left - Bottom",
	'user_support:settings:help_center:show_floating_button:right_top' => "Right - Top",
	'user_support:settings:help_center:show_floating_button:right_bottom' => "Right - Bottom",
	'user_support:settings:help_center:float_button_offset' => "Vertical offset of the floating button",
	'user_support:settings:help_center:float_button_offset:help' => "Offset in pixels",
	'user_support:settings:help_center:show_as_popup' => "Show the Help Center in a popup",
		
	'user_support:settings:faq:title' => "FAQ Settings",
	'user_support:settings:faq:add_faq_site_menu_item' => "Add a site menu item to the FAQ",
	'user_support:settings:faq:add_faq_footer_menu_item' => "Add a footer menu item to the FAQ",
	
	'user_support:settings:faq:group_faq' => "Enable FAQ in groups",
	'user_support:settings:faq:group_faq:yes_off' => "Yes, default disabled",
	'user_support:settings:faq:group_faq:yes' => "Yes, default enabled",
	
	// notification settings
	'user_support:notifications:support_ticket' => "Receive a notification when a Support Ticket is created/updated",
	
	// annotations
	'river:comment:object:support_ticket' => "%s posted a comment on %s",
	'river:create:object:support_ticket' => "%s posted a comment on %s",
	'user_support:support_ticket:closed' => "Your Support Ticket has been closed",
	'user_support:support_ticket:reopened' => "Your Support Ticket has been reopened",
	
	'user_support:notify:user:create:message' => "Thank you for reporting a new Support Ticket. We will try to help you as soon as possible.

To view the Ticket click on this link:
%s

Go to the next link to list all your reported tickets.
%s
",
	
	// admin notify
	'user_support:notify:admin:create:subject' => "A new Support Ticket '%s' was reported",
	'user_support:notify:admin:create:summary' => "A new Support Ticket '%s' was reported",
	'user_support:notify:admin:create:message' => "%s reported a new Support Ticket:
%s

To view the Ticket click on this link:
%s",
	
	'user_support:notify:admin:updated:subject' => "The Support Ticket '%s' was updated",
	'user_support:notify:admin:updated:summary' => "The Support Ticket '%s' was updated",
	'user_support:notify:admin:updated:message' => "%s updated the Support Ticket '%s':
%s

To view the Ticket click on this link:
%s",

	// menu
	'user_support:menu:support_tickets' => "Support tickets",
	'user_support:menu:support_tickets:archive' => "Support tickets archive",
	'user_support:menu:support_tickets:mine' => "My Support tickets",
	'user_support:menu:support_tickets:mine:archive' => "My closed Support tickets",
	'user_support:menu:support_tickets:staff' => "Support staff",
	
	'user_support:menu:faq' => "FAQ",
	'user_support:menu:faq:group' => "Group FAQ",
	'add:object:faq' => "Create FAQ",
	
	'user_support:menu:user_hover:make_staff' => "Add to the support staff",
	'user_support:menu:user_hover:remove_staff' => "Remove from the support staff",
	
	'user_support:menu:entity:comment_promote' => "Make FAQ",
	'user_support:menu:entity:comment_promote:title' => "Make this comment into an FAQ",
	
	// button
	'user_support:button:text' => "Support",
	'user_support:button:hover' => "Click to open the Help Center",
	
	'user_support:help_center:title' => "Help Center",
	'user_support:help_center:ask' => "Ask a question",
	'user_support:help_center:help' => "Create help",
	'user_support:help_center:help:title' => "Contextual help",
	'user_support:help_center:faq:title' => "FAQ",
	'user_support:help_center:help_group' => "Help group",
	
	'user_support:help_center:search' => "Search in the help and FAQ",

	// forms
	'user_support:forms:help:title' => "Create Contextual Help",
	'user_support:forms:help:title:edit' => "Edit Contextual Help",
	'user_support:forms:help:no_context' => "The system was unable to detect a help context on this page, creating a help here is not possible",
	'user_support:faq:edit:title:edit' => "Edit a FAQ item",
	'user_support:faq:create:title' => "Create a FAQ item",

	// ticket - list
	'user_support:tickets:list:title' => "Support tickets",
	
	// ticket - mine
	'user_support:tickets:mine:title' => "My Support Tickets",
	'user_support:tickets:mine:archive:title' => "My closed Support Tickets",
	'user_support:tickets:owner:title' => "%s Support Tickets",
	'user_support:tickets:owner:archive:title' => "%s closed Support Tickets",
	
	// ticket - archive
	'user_support:tickets:archive:title' => "Support tickets archive",
	
	// ticket - staff
	'user_support:tickets:staff:title' => "Support staff",
	'user_support:tickets:staff:no_results' => "No users assigned as support staff. Site administrators always are support staff.",

	// faq - list
	'user_support:faq:sidebar:filter' => "Filter FAQ on tag",
	'user_support:faq:list:title' => "View all FAQ items",
	'user_support:faq:not_found' => "No FAQ items available",
	'user_support:faq:context' => "Related FAQs",
	'user_support:faq:read_more' => "Read %s more FAQs",
	
	// group faq
	'user_support:group:tool_option' => "Enable support for group FAQs",
	'user_support:faq:group:title' => "%s FAQ",

	// widgets
	'widgets:faq:name' => "FAQ",
	'widgets:faq:description' => "Show a list of the most recently added FAQ items",
	
	'widgets:support_ticket:name' => "Support tickets",
	'widgets:support_ticket:description' => "Shows you a list of your support tickets",
	'user_support:widgets:support_ticket:filter' => "Which tickets do you wish to see",
	'user_support:widgets:support_ticket:filter:all' => "All",
	
	'widgets:support_staff:name' => "Support staff",
	'widgets:support_staff:description' => "Shows you a list of the open support tickets",
	
	// actions
	// help - edit
	'user_support:action:help:edit:error:save' => "An unknown error occurred while saving the contextual help",
	'user_support:action:help:edit:success' => "The contextual help was saved successfully",
	
	// ticket - edit
	'user_support:action:ticket:edit:error:save' => "An unknown error occurred while saving the support ticket",
	'user_support:action:ticket:edit:success' => "The support ticket was saved successfully",

	// faq - edit
	'user_support:action:faq:edit:error:save' => "An unknown error occurred while saving the FAQ",
	'user_support:action:faq:edit:success' => "The FAQ was created/edited successfully",
	
	// ticket = close
	'user_support:action:ticket:close:error:disable' => "An unknown error occurred while closing the Support Ticket",
	'user_support:action:ticket:close:success' => "The Support Ticket was closed successfully",
	
	// ticket - reopen
	'user_support:action:ticket:reopen:error:enable' => "An unknown error occurred while reopening the Support Ticket",
	'user_support:action:ticket:reopen:success' => "The Support Ticket was reopened successfully",
	
	// support staff
	'user_support:action:support_staff:added' => "The user is added to the support staff",
	'user_support:action:support_staff:removed' => "The user was removed from the support staff",
);
