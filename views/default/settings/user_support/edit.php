<?php 

	$plugin = $vars["entity"];

	if(is_plugin_enabled("groups")){
		$group_options = array(
			"type" => "group",
			"limit" => false
		);
		
		if($groups = elgg_get_entities($group_options)){
			$group_options_value = array();
			
			foreach($groups as $group){
				$group_options_value[$group->getGUID()] = $group->name;
			}
			
			natcasesort($group_options_value);
			
			$group_options_value = array(0 => elgg_echo("user_support:settings:help_group:non")) + $group_options_value;
		}
		
		echo "<div>" . elgg_echo("user_support:settings:help_group") . "</div>";
		echo elgg_view("input/pulldown", array("internalname" => "params[help_group_guid]", "options_values" => $group_options_value, "value" => (int) $plugin->help_group_guid));
	}

?>