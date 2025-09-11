<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \UserSupportFAQ) {
	return;
}

$body = elgg_view('output/longtext', [
	'value' => $entity->description,
]);

$params = [
	'icon' => false,
	'body' => $body,
	'show_summary' => true,
	'byline' => !($entity->getContainerEntity() instanceof \ElggSite),
];
$params = $params + $vars;
echo elgg_view('object/elements/full', $params);
