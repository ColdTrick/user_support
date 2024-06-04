<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \UserSupportHelp) {
	return;
}

$params = [
	'title' => elgg_echo('user_support:help_center:help:title'),
	'content' => elgg_view('output/longtext', ['value' => $entity->description]),
	'subtitle' => false,
];
$params = $params + $vars;
echo elgg_view('object/elements/summary', $params);
