<?php 

	$plugin = $vars["entity"];
	$user = elgg_get_logged_in_user_entity();
	$page_owner = elgg_get_page_owner_entity();
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
	
	if($page_owner->getGUID() == $user->getGUID()){
		if($user->isAdmin()){
			$body = "<div>";
			$body .= elgg_echo("user_support:usersettings:admin_notify") . "<br />";
			$body .= elgg_view("input/dropdown", array("name" => "params[admin_notify]", "options_values" => $noyes_options, "value" => $plugin->admin_notify));
			$body .= "</div>";
			
			echo $body;
		}
	}