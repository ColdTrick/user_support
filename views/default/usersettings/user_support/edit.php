<?php 

	$plugin = $vars["entity"];
	$user = get_loggedin_user();
	$page_owner = page_owner_entity();
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
	if($page_owner->getGUID() == $user->getGUID()){
		if($user->isAdmin()){
			$body = "<div>" . elgg_echo("user_support:usersettings:admin_notify") . "</div>";
			$body .= elgg_view("input/pulldown", array("internalname" => "params[admin_notify]", "options_values" => $noyes_options, "value" => $plugin->admin_notify));
			
			echo $body;
		}
	}