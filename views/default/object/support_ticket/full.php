<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \UserSupportTicket) {
	return;
}

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
	'body' => $body,
	'show_summary' => true,
	'icon' => true,
	'imprint' => $imprint,
	'access' => false,
];
$params = $params + $vars;
echo elgg_view('object/elements/full', $params);
