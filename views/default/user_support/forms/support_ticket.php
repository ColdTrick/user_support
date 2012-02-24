<?php 

	$types_values = array(
		"question" => elgg_echo("user_support:support_type:question"),
		"bug" => elgg_echo("user_support:support_type:bug"),
		"request" => elgg_echo("user_support:support_type:request"),
	);

	if(!empty($vars["entity"])){
		$edit = true;
		$entity = $vars["entity"];
		
		$title = $entity->title;
		$desc = $entity->description;
		$tags = $entity->tags;
		$help_url = $entity->help_url;
		$support_type = $entity->support_type;
		
		$form_body = elgg_view("input/hidden", array("internalname" => "guid", "value" => $entity->getGUID()));
		$form_body .= elgg_view("input/hidden", array("internalname" => "help_context", "value" => $entity->help_context));
	} else {
		$edit = false;
		
		$title = "";
		$tags = array();
		$help_url = $vars["help_url"];
		$support_type = "";
		
		if(!empty($vars["help_context"])){
			$form_body = elgg_view("input/hidden", array("internalname" => "help_context", "value" => $vars["help_context"]));
		} else {
			$form_body = elgg_view("input/hidden", array("internalname" => "help_context", "value" => user_support_get_help_context()));
		}
	}
	
	$form_body .= "<div>" . elgg_echo("user_support:question") . "</div>";
	$form_body .= elgg_view("input/plaintext", array("internalname" => "title", "value" => $title));
	
	$form_body .= "<div>" . elgg_echo("user_support:support_type") . "</div>";
	$form_body .= elgg_view("input/pulldown", array("internalname" => "support_type", "options_values" => $types_values, "value" => $support_type));
	
	$form_body .= "<div>" . elgg_echo("tags") . "</div>";
	$form_body .= elgg_view("input/tags", array("internalname" => "tags", "value" => $tags));
	
	$form_body .= "<div>" . elgg_echo("user_support:url") . "</div>";
	$form_body .= elgg_view("input/url", array("internalname" => "help_url", "value" => $help_url));

	$form_body .= "<div>";
	$form_body .= elgg_view("input/submit", array("value" => elgg_echo("save")));
	$form_body .= "</div>";
	
	$form = elgg_view("input/form", array("body" => $form_body,
											"action" => $vars["url"] . "action/user_support/ticket/edit",
											"internalid" => "user_support_ticket_edit_form"));
	echo $form;
?>