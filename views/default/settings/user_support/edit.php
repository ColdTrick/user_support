<?php 

	$plugin = $vars["entity"];
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);

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
	
	echo "<div>" . elgg_echo("user_support:settings:auto_close_tickets") . "</div>";
	echo elgg_view("input/pulldown", array("internalname" => "params[auto_close_tickets]", "options_values" => $noyes_options, "value" => (int) $plugin->auto_close_tickets));

?>