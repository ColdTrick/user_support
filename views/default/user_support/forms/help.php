<?php 

	if(!empty($vars["entity"])){
		$entity = $vars["entity"];
		
		$desc = $entity->description;
		$tags = $entity->tags;
		
		$form_body = elgg_view("input/hidden", array("internalname" => "guid", "value" => $entity->getGUID()));
		$form_body .= elgg_view("input/hidden", array("internalname" => "help_context", "value" => $entity->help_context));
	} else {
		
		$desc = "";
		$tags = array();
		
		if(!empty($vars["help_context"])){
			$form_body = elgg_view("input/hidden", array("internalname" => "help_context", "value" => $vars["help_context"]));
		} else {
			$form_body = elgg_view("input/hidden", array("internalname" => "help_context", "value" => user_support_get_help_context()));
		}
	}
	$form_body .= "<h3 class='settings'>" . elgg_echo("user_support:forms:help:title") . "</h3>";
	$form_body .= "<div>" . elgg_echo("description") . "</div>";
	$form_body .= elgg_view("input/plaintext", array("internalname" => "description", "value" => $desc));
	
	$form_body .= "<div>" . elgg_echo("tags") . "</div>";
	$form_body .= elgg_view("input/tags", array("internalname" => "tags", "value" => $tags));
	
	$form_body .= "<div>";
	$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));
	$form_body .= "</div>";

	$form = elgg_view("input/form", array("body" => $form_body,
											"action" => $vars["url"] . "action/user_support/help/edit",
											"internalid" => "user_support_help_edit_form"));
	
	echo $form;
?>
