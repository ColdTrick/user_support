<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof UserSupportTicket) {
	return;
}

$full_view = (bool) elgg_extract('full_view', $vars);

$owner = $entity->getOwnerEntity();

$vars['access'] = false;

if (!$full_view) {
	// summary (listing) view
	
	// title
	$title = elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ';

	$title .= elgg_view('output/url', [
		'href' => $entity->getURL(),
		'text' => $entity->getDisplayName(),
		'is_trusted' => true,
	]);
		
	$params = [
		'entity' => $entity,
		'content' => $info,
		'title' => $title,
	];
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
} else {
	// full view
	
	// summary
	$params = [
		'entity' => $entity,
		'title' => false,
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
	echo elgg_view('object/elements/full', [
		'entity' => $entity,
		'summary' => $summary,
		'icon' => $icon,
		'body' => $body,
	]);
}
