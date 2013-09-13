<?php
	function user_support_page_handler($page){
		$result = false;
		
		switch($page[0]){
			case "help":
				$result = true;
				
				include(dirname(dirname(__FILE__)) . "/pages/support_ticket/list.php");
				break;
			case "faq":
				$result = true;
				
				switch($page[1]){
					case "edit":
						if(!empty($page[2]) && is_numeric($page[2])){
							set_input("guid", $page[2]);
						}
						include(dirname(dirname(__FILE__)) . "/pages/faq/edit.php");
						break;
					case "group":
						if (!empty($page[2]) && is_numeric($page[2])) {
							elgg_set_page_owner_guid($page[2]);
						}
						include(dirname(dirname(__FILE__)) . "/pages/faq/group.php");
						break;
					case "add":
						if (!empty($page[2]) && is_numeric($page[2])) {
							elgg_set_page_owner_guid($page[2]);
						}
						include(dirname(dirname(__FILE__)) . "/pages/faq/add.php");
						break;
					default:
						if(!empty($page[1]) && is_numeric($page[1])){
							set_input("guid", $page[1]);
							include(dirname(dirname(__FILE__)) . "/pages/faq/view.php");
						} else {
							include(dirname(dirname(__FILE__)) . "/pages/faq/list.php");
						}
						break;
				}
				break;
			case "support_ticket":
				$result = true;
				
				switch($page[1]){
					case "edit":
						if(!empty($page[2]) && is_numeric($page[2])){
							set_input("guid", $page[2]);
						}
						include(dirname(dirname(__FILE__)) . "/pages/support_ticket/edit.php");
						break;
					case "archive":
						include(dirname(dirname(__FILE__)) . "/pages/support_ticket/archive.php");
						break;
					case "mine":
						if(!empty($page[2]) && ($page[2] == "archive")){
							set_input("status", UserSupportTicket::CLOSED);
						}
						include(dirname(dirname(__FILE__)) . "/pages/support_ticket/mine.php");
						break;
					default:
						if(!empty($page[1]) && is_numeric($page[1])){
							set_input("guid", $page[1]);
							include(dirname(dirname(__FILE__)) . "/pages/support_ticket/view.php");
						} else {
							include(dirname(dirname(__FILE__)) . "/pages/support_ticket/list.php");
						}
						break;
				}
				break;
			case "help_center":
				$result = true;
				
				include(dirname(dirname(__FILE__)) . "/pages/help_center.php");
				break;
			case "search":
				$result = true;
				
				include(dirname(dirname(__FILE__)) . "/procedures/search.php");
				break;
		}
		
		return $result;
	}