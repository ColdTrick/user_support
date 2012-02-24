<?php 

	$english = array(
	
		// objects
		'item:object:faq' => "User support FAQ",
		'item:object:help' => "User support Contextual help",
		'item:object:support_ticket' => "User support Ticket",
		
		// general
		'user_support:support_type' => "Category",
		'user_support:support_type:question' => "Question",
		'user_support:support_type:bug' => "Bug",
		'user_support:support_type:request' => "Feature request",
	
		'user_support:anwser' => "Answer",
		'user_support:anwser:short' => "A",
		'user_support:question' => "Question",
		'user_support:question:short' => "Q",
		'user_support:url' => "URL",
		'user_support:allow_comments' => "Allow comments",
		'user_support:read_more' => "Read more",
		'user_support:help_context' => "Contextual help",
		'user_support:reopen' => "Reopen",
		'user_support:last_comment' => "last comment by: %s",
	
		// settings
		'user_support:settings:help_group' => "Select a group for users to ask for help",
		'user_support:settings:help_group:non' => "No support group",
	
		// annotations
		'support_ticket:river:annotate' => "a comment on",
		'user_support:support_ticket:closed' => "Your Support Ticket has been closed",
		'user_support:support_ticket:reopened' => "Your Support Ticket has been reopened",
	
		// menu
		'user_support:menu:support_tickets' => "Support tickets",
		'user_support:menu:support_tickets:archive' => "Support tickets archive",
		'user_support:menu:support_tickets:mine' => "My Support tickets",
		'user_support:menu:support_tickets:mine:archive' => "My closed Support tickets",
		
		'user_support:menu:faq' => "FAQ",
		'user_support:menu:faq:create' => "Create FAQ",
		
		// button
		'user_support:button:text' => "Support",
		'user_support:button:hover' => "Click to open the Help Center",
		
		'user_support:help_center:title' => "Help Center",
		'user_support:help_center:ask' => "Ask a question",
		'user_support:help_center:help' => "Create help",
		'user_support:help_center:faq:title' => "FAQ",
		'user_support:help_center:help_group' => "Help group",
	
		// forms
		'user_support:forms:help:title' => "Create Contextual Help",
		'user_support:faq:edit:title:edit' => "Edit a FAQ item",
		'user_support:faq:edit:title:create' => "Create a FAQ item",
	
		// ticket - list
		'user_support:tickets:list:title' => "Support tickets",
		'user_support:ticket:list:not_found' => "No support tickets found",
	
		// ticket - mine
		'user_support:tickets:mine:title' => "My Support Tickets",
		'user_support:tickets:mine:archive:title' => "My closed Support Tickets",
	
		// ticket - archive
		'user_support:tickets:archive:title' => "Support tickets archive",
	
		// faq - list
		'user_support:faq:list:title' => "View all FAQ items",
		'user_support:faq:not_found' => "No FAQ items available",
	
		// actions
		// help - edit
		'user_support:action:help:edit:error:input' => "Invalid input to create/edit this contextual help",
		'user_support:action:help:edit:error:save' => "An unknown error occured while saving the contextual help",
		'user_support:action:help:edit:error:create' => "An unknown error occured while creating the contextual help",
		'user_support:action:help:edit:error:entity' => "The given GUID is not a contextual help",
		'user_support:action:help:edit:success' => "The contextual help was saved successfully",
		
		// help - delete
		'user_support:action:help:delete:error:input' => "Invalid input to delete contextual help",
		'user_support:action:help:delete:error:subtype' => "The given GUID is not a contextual help",
		'user_support:action:help:delete:error:delete' => "An unknown error occured while deleting the contextual help",
		'user_support:action:help:delete:success' => "The contextual help was delete successfully",
	
		// ticket - edit
		'user_support:action:ticket:edit:error:input' => "Invalid input to create/edit a support ticket",
		'user_support:action:ticket:edit:error:save' => "An unknown error occured while saving the support ticket",
		'user_support:action:ticket:edit:error:create' => "An unknown error occured while creating the support ticket",
		'user_support:action:ticket:edit:error:entity' => "The given GUID is not a support ticket",
		'user_support:action:ticket:edit:success' => "The support ticket was saved successfully",
	
		// ticket - delete
		'user_support:action:ticket:delete:error:input' => "Invalid input to delete the support ticket",
		'user_support:action:ticket:delete:error:entity' => "The given GUID is not a support ticket",
		'user_support:action:ticket:delete:error:can_edit' => "You're not allowed to edit the support ticket",
		'user_support:action:ticket:delete:error:delete' => "An unknown error occured while deleting the support ticket",
		'user_support:action:ticket:delete:success' => "Support ticket successfully deleted",
		
		// faq - delete
		'user_support:action:faq:delete:error:input' => "Incorrect input to delete the FAQ",
		'user_support:action:faq:delete:error:entity' => "The given GUID is not an FAQ",
		'user_support:action:faq:delete:error:delete' => "An unknown error occured while deleting the FAQ, please try again",
		'user_support:action:faq:delete:success' => "The FAQ was deleted successfully",
		
		// faq - edit
		'user_support:action:faq:edit:error:input' => "Incorrect input to create/edit the FAQ, please provide a Question and an Anwser",
		'user_support:action:faq:edit:error:save' => "An error occured while saving the FAQ",
		'user_support:action:faq:edit:error:entity' => "The given GUID is not an FAQ",
		'user_support:action:faq:edit:error:create' => "An error occured while creating the FAQ",
		'user_support:action:faq:edit:success' => "The FAQ was created/edited successfully",
		
		// ticket = close
		'user_support:action:ticket:close:error:input' => "Incorrect input to close a Support Ticket",
		'user_support:action:ticket:close:error:subtype' => "The given GUID is not a Support Ticket",
		'user_support:action:ticket:close:error:disable' => "An unknown error occured while closing the Support Ticket",
		'user_support:action:ticket:close:success' => "The Support Ticket was closed successfully",
		
		// ticket - reopen
		'user_support:action:ticket:reopen:error:input' => "Incorrect input to reopen a Support Ticket",
		'user_support:action:ticket:reopen:error:subtype' => "The given GUID is not a Support Ticket",
		'user_support:action:ticket:reopen:error:enable' => "An unknown error occured while reopening the Support Ticket",
		'user_support:action:ticket:reopen:success' => "The Support Ticket was reopened successfully",
		
		'' => "",
	
	);
	
	add_translation("en", $english);

?>