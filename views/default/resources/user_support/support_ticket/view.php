<?php

$guid = (int) elgg_extract('guid', $vars);

// ignore access for support staff
$flag = user_support_is_support_staff() ? ELGG_IGNORE_ACCESS : 0;

echo elgg_call($flag, function() use ($guid) {

	/** @var \UserSupportTicket $entity */
	$entity = elgg_entity_gatekeeper($guid, 'object', \UserSupportTicket::SUBTYPE);
		
	$title_text = elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ' . $entity->getDisplayName();
	
	elgg_push_entity_breadcrumbs($entity);
		
	return elgg_view_page($title_text, [
		'content' => elgg_view_entity($entity),
		'entity' => $entity,
		'filter_id' => 'support_ticker/view',
		'filter_value' => 'view',
	]);
});
