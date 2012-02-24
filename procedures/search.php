<?php 

	$q = sanitise_string(get_input("q"));
	
	$params = array(
		"query" => $q,
		"search_type" => "entities",
		"type" => "object",
		"subtype" => UserSupportFAQ::SUBTYPE,
		"limit" => 5,
		"offset" => 0,
		"sort" => "relevance",
		"order" => "desc",
		"owner_guid" => ELGG_ENTITIES_ANY_VALUE,
		"container_guid" => ELGG_ENTITIES_ANY_VALUE,
		"pagination" => false
	);
	
	if($result = trigger_plugin_hook("search", "object:" . UserSupportFAQ::SUBTYPE, $params, array())){
		$entities = $result["entities"];
	} elseif($result = trigger_plugin_hook("search", "object", $params, array())){
		$entities = $result["entities"];
	}
	
	echo "<h3 class='settings'>" . sprintf(elgg_echo("search:results"), "\"" . $q . "\"") . "</h3>";
	
	if(!empty($entities)){
		$context = get_context();
		set_context("search");
		
		echo elgg_view_entity_list($entities, $result["count"], 0, 5, false, false, false);
		
		set_context($context);
	} else {
		echo elgg_echo("search:no_results");
	}
	
?>