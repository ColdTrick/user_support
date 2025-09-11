<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \UserSupportFAQ) {
	return;
}

// answer
$info = elgg_get_excerpt((string) $entity->description, 150);
$info .= elgg_view('output/url', [
	'href' => $entity->getURL(),
	'text' => elgg_echo('user_support:read_more'),
	'class' => 'mlm',
]);

// brief view
$params = [
	'content' => elgg_format_element('div', [], $info),
	'icon' => false,
	'byline' => !($entity->getContainerEntity() instanceof \ElggSite),
];
$params = $params + $vars;
echo elgg_view('object/elements/summary', $params);
