<?php 


	function user_support_get_help_for_context($help_context){
		$result = false;
		
		if(!empty($help_context)){
			$options = array(
				"type" => "object",
				"subtype" => UserSupportHelp::SUBTYPE,
				"site_guids" => false,
				"limit" => false,
				"metadata_name_value_pairs" => array("help_context" => $help_context)
			);
			
			if($help = elgg_get_entities_from_metadata($options)){
				$result = $help[0];
			}
		}
		
		return $result;
	}
	
	function user_support_get_help_context($url = ""){
		global $CONFIG;
		
		$result = false;
		
		if(empty($url)){
			$url = current_page_url();
		}
		
		if(!empty($url)){
			if($path = parse_url($url, PHP_URL_PATH)){
				$parts = explode("/", $path);
				
				$new_parts = array();
				
				foreach($parts as $index => $part){
					if(empty($part) || ($part == "pg")){
						continue;
					} elseif(is_numeric($part) || get_user_by_username($part) || (stripos($part, "group:") !== false)){
						break;
					} else {
						$new_parts[] = $part;
					}
				}
				
				if(!empty($new_parts)){
					$result = implode("/", $new_parts);
				}
			}
		}
		
		return $result;
	}
	
	function user_support_time_created_string(ElggObject $entity){
		$result = false;
		
		if(!empty($entity) && ($entity instanceof ElggObject)){
			if($date_array = getdate($entity->time_created)){
				$result = sprintf(elgg_echo("date:month:" . str_pad($date_array["mon"], 2, "0", STR_PAD_LEFT)), $date_array["mday"]) . " " . $date_array["year"];
			}
		}
		
		return $result;
	}
	
	function user_support_find_unique_help_context(){
		$result = false;
		
		// get all metadata values of help_context
		if($metadata = find_metadata("help_context", "", "object", "", 99999)){
			// make it into an array
			if($filtered = metadata_array_to_values($metadata)){
				//get unique values
				$result = array_unique($filtered);
				natcasesort($result);
			}
		}
		
		return $result;
	}
	
	function user_support_get_admin_notify_users(UserSupportTicket $ticket){
		global $CONFIG;
		
		$result = false;
		
		if(!empty($ticket) && ($ticket instanceof UserSupportTicket)){
			$options = array(
				"type" => "user",
				"limit" => false,
				"site_guids" => false,
				"relationship" => "member_of_site",
				"relationship_guid" => $CONFIG->site_guid,
				"inverse_relationship" => true,
				"joins" => array(
					"JOIN " . $CONFIG->dbprefix . "private_settings ps ON e.guid = ps.entity_guid",
					"JOIN " . $CONFIG->dbprefix . "users_entity ue ON e.guid = ue.guid"
				),
				"wheres" => array(
					"(ps.name = 'plugin:settings:user_support:admin_notify' AND ps.value = 'yes')",
					"(ue.admin = 'yes')",
					"(e.guid <> " . $ticket->getOwner() . ")"
				)
			);
				
			$users = elgg_get_entities_from_relationship($options);
				
			// trigger hook to get more/less users
			$users = trigger_plugin_hook("admin_notify", "user_support", array("users" => $users, "entity" => $ticket), $users);

			if(!empty($users)){
				if(is_array($users)){
					$result = $users;
				} else {
					$result = array($users);
				}
			}
		}
		
		return $result;
	}

?>