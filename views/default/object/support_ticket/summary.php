<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \UserSupportTicket) {
	return;
}

// title
$title = elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ';
$title .= elgg_view_entity_url($entity);

$params = [
	'entity' => $entity,
	'title' => $title,
	'icon' => elgg_view_entity_icon($entity),
	'access' => false,
];
$params = $params + $vars;
echo elgg_view('object/elements/summary', $params);
