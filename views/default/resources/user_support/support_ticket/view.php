<?php

$guid = (int) elgg_extract('guid', $vars);
$title_text = '';

// ignore access for support staff
$flag = user_support_staff_gatekeeper(false) ? ELGG_IGNORE_ACCESS : 0;

$page_data = elgg_call($flag, function() use ($guid, &$title_text) {
	elgg_entity_gatekeeper($guid, 'object', UserSupportTicket::SUBTYPE);
	
	/* @var $entity \UserSupportTicket */
	$entity = get_entity($guid);
	
	// build page elements
	$title_text = elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ' . $entity->getDisplayName();
	
	elgg_push_entity_breadcrumbs($entity);
	
	// show entity
	$content = elgg_view_entity($entity);
	
	// build page
	return elgg_view_layout('default', [
		'title' => $title_text,
		'content' => $content,
		'entity' => $entity,
		'filter' => false,
	]);
});

// draw page
echo elgg_view_page($title_text, $page_data);
