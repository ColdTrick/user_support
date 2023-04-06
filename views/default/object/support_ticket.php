<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \UserSupportTicket) {
	return;
}

$vars['access'] = false;

if (!(bool) elgg_extract('full_view', $vars)) {
	// summary (listing) view
	
	// title
	$title = elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ';
	$title .= elgg_view_entity_url($entity);
		
	$params = [
		'entity' => $entity,
		'title' => $title,
		'icon' => elgg_view_entity_icon($entity),
	];
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
} else {
	// full view
	$imprint = [];
	if ($entity->getStatus() === \UserSupportTicket::OPEN) {
		$imprint[] = [
			'icon_name' => 'unlock',
			'content' => elgg_echo('status:open'),
		];
	} else {
		$imprint[] = [
			'icon_name' => 'lock',
			'content' => elgg_echo('status:closed'),
		];
	}
	
	// summary
	$params = [
		'entity' => $entity,
		'title' => false,
		'icon' => true,
		'imprint' => $imprint,
	];
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	
	// body
	$body = '';
	if (!empty($entity->help_url)) {
		$help_url = elgg_echo('user_support:url:info', ["<a href='{$entity->help_url}'>", '</a>']);
		
		$body .= elgg_format_element('div', [], $help_url);
	}
	
	if (!empty($entity->description)) {
		$body .= elgg_view('output/longtext', [
			'value' => $entity->description,
		]);
	} elseif (strlen($entity->title) > 50) {
		$body .= elgg_view('output/longtext', [
			'value' => $entity->getDisplayName(),
		]);
	}
	
	// ticket
	$params = [
		'entity' => $entity,
		'summary' => $summary,
		'body' => $body,
	];
	$params = $params + $vars;
	echo elgg_view('object/elements/full', $params);
}
