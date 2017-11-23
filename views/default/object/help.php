<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof UserSupportHelp) {
	return;
}

$full_view = (bool) elgg_extract('full_view', $vars, false);

// entity menu
$entity_menu = '';
if (!elgg_in_context('widgets')) {
	$entity_menu = elgg_view_menu('entity', [
		'entity' => $entity,
		'handler' => 'user_support/help',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

if (!$full_view) {
	
	$params = [
		'title' => elgg_echo('user_support:help_center:help:title'),
		'metadata' => $entity_menu,
		'content' => elgg_view('output/longtext', ['value' => $entity->description]),
	];
	$params = array_merge($params, $vars);
	
	echo elgg_view('object/elements/summary', $params);
}
