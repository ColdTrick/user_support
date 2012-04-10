<?php 

	$entity = elgg_extract("entity", $vars);
	$full_view = elgg_extract("full_view", $vars, false);
	
	// entity menu
	$entity_menu = elgg_view_menu("entity", array(
		"entity" => $entity,
		"handler" => "user_support/faq",
		"sort_by" => "priority",
		"class" => "elgg-menu-hz"
	));
	
	if(elgg_in_context("widgets")){
		unset($entity_menu);
	}
	
	if(!$full_view){
		$icon = elgg_view_entity_icon($entity, "small");
		
		// anwser
		$info = "<div>";
		$info .= elgg_echo("user_support:anwser:short") . ": " . elgg_get_excerpt($entity->description, 150);
		$info .= "&nbsp;" . elgg_view("output/url", array("href" => $entity->getURL(), "text" => elgg_echo("user_support:read_more")));
		$info .= "</div>";
		
		$params = array(
			"entity" => $entity,
			"metadata" => $entity_menu,
			"content" => $info,
			"title" => elgg_view("output/url", array("href" => $entity->getURL(), "text" => $entity->title))
		);
		$params = $params + $vars;
		$list_body = elgg_view("object/elements/summary", $params);
		
		echo elgg_view_image_block($icon, $list_body);
	} else {
		$owner = $entity->getOwnerEntity();
		
		// icon
		$icon = elgg_view_entity_icon($entity, "tiny");
		
		// summary
		$params = array(
			"entity" => $entity,
			"metadata" => $entity_menu,
			"tags" => elgg_view("output/tags", array("value" => $entity->tags)),
			"subtitle" => user_support_time_created_string($entity),
			"title" => false
		);
		$params = $params + $vars;
		$summary = elgg_view("object/elements/summary", $params);
		
		// body
		$body = elgg_echo("user_support:anwser") . ": ";
		$body .= elgg_view("output/longtext", array("value" => $entity->description));
		
		// blog
		echo elgg_view('object/elements/full', array(
				'summary' => $summary,
				'icon' => $icon,
				'body' => $body,
		));
	}
