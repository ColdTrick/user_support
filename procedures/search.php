<?php 

	$q = sanitise_string(get_input("q"));
	
	$params = array(
		"query" => $q,
		"search_type" => "entities",
		"type" => "object",
		"subtype" => UserSupportHelp::SUBTYPE,
		"limit" => 5,
		"offset" => 0,
		"sort" => "relevance",
		"order" => "desc",
		"owner_guid" => ELGG_ENTITIES_ANY_VALUE,
		"container_guid" => ELGG_ENTITIES_ANY_VALUE,
		"pagination" => false
	);
	
	if($result = trigger_plugin_hook("search", "object:" . UserSupportHelp::SUBTYPE, $params, array())){
		$help_entities = $result["entities"];
	} elseif($result = trigger_plugin_hook("search", "object", $params, array())){
		$help_entities = $result["entities"];
	}
	
	echo "<h3 class='settings'>" . sprintf(elgg_echo("search:results"), "\"" . $q . "\"") . "</h3>";
	
	if(!empty($help_entities)){
		$context = get_context();
		set_context("search");
		
		echo elgg_view_entity_list($help_entities, $result["count"], 0, 5, false, false, false);
		
		set_context($context);
	}
	
	// Search in FAQ
	$params["subtype"] = UserSupportFAQ::SUBTYPE;
	
	if($result = trigger_plugin_hook("search", "object:" . UserSupportFAQ::SUBTYPE, $params, array())){
		$faq_entities = $result["entities"];
	} elseif($result = trigger_plugin_hook("search", "object", $params, array())){
		$faq_entities = $result["entities"];
	}
	
	if(!empty($faq_entities)){
		$context = get_context();
		set_context("search");
		
		echo elgg_view_entity_list($faq_entities, $result["count"], 0, 5, false, false, false);
		
		set_context($context);
	}
	
	if(empty($help_entities) && empty($faq_entities)){
		echo elgg_echo("search:no_results");
	}
	
?>