<?php 

	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);

	$access_options = array(
		ACCESS_PRIVATE => elgg_echo("PRIVATE"),
		ACCESS_LOGGED_IN => elgg_echo("LOGGED_IN"),
		ACCESS_PUBLIC => elgg_echo("PUBLIC"),
	);
	
	$help_context = $vars["help_context"];
	
	if(!empty($vars["entity"])){
		$entity = $vars["entity"];
		
		$title = $entity->title;
		$desc = $entity->description;
		$access_id = $entity->access_id;
		
		$tags = $entity->tags;
		$comments = $entity->allow_comments;
		$context = $entity->help_context;
		if(!empty($context) && !is_array($context)){
			$context = array($context);
		} elseif(empty($context)){
			$context = array();
		}
		
		$submit_text = elgg_echo("edit");
		
		$form_data = elgg_view("input/hidden", array("internalname" => "guid", "value" => $entity->getGUID()));
	} else {
		$title = "";
		$desc = "";
		$acess_id = ACCESS_PUBLIC;
		
		$tags = array();
		$comments = "no";
		$context = array();
		
		$submit_text = elgg_echo("submit");
	}

	$form_data .= "<div>" . elgg_echo("user_support:question") . "</div>";
	$form_data .= elgg_view("input/text", array("internalname" => "title", "value" => $title));
	
	$form_data .= "<div>" . elgg_echo("user_support:anwser") . "</div>";
	$form_data .= elgg_view("input/longtext", array("internalname" => "description", "value" => $desc));

	$form_data .= "<div>" . elgg_echo("tags") . "</div>";
	$form_data .= elgg_view("input/tags", array("internalname" => "tags", "value" => $tags));
	
	if(isadminloggedin() && !empty($help_context)){
		$form_data .= "<div>" . elgg_echo("user_support:help_context") . "</div>";
		
		$form_data .= "<select name='help_context[]' multiple='multiple' size='" . min(count($help_context), 5) . "'>";
		foreach($help_context as $hc){
			$selected = "";
			if(in_array($hc, $context)){
				$selected = "selected='selected'";
			}
			$form_data .= "<option value='" . $hc . "' " . $selected . ">" . $hc . "</option>";
		}
		$form_data .= "</select>";
	}
	
	$form_data .= "<div>" . elgg_echo("access") . "</div>";
	$form_data .= elgg_view("input/access", array("internalname" => "access_id", "value" => $access_id, "options" => $access_options));

	$form_data .= "<div>" . elgg_echo("user_support:allow_comments") . "</div>";
	$form_data .= elgg_view("input/pulldown", array("internalname" => "allow_comments", "options_values" => $noyes_options, "value" => $comments));
	
	$form_data .= "<div>";
	$form_data .= elgg_view("input/submit", array("value" => $submit_text));
	$form_data .= "</div>";

	$form = elgg_view("input/form", array("body" => $form_data,
											"action" => $vars["url"] . "action/user_support/faq/edit",
											"internalid" => "user_support_faq_edit_form"));
?>
<div class="contentWrapper">
	<?php echo $form; ?>
</div>