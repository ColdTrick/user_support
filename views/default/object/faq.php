<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \UserSupportFAQ) {
	return;
}

$full_view = (bool) elgg_extract('full_view', $vars, false);

if ($entity->getContainerEntity() instanceof \ElggSite) {
	$vars['byline'] = false;
}

// entity menu
if (!$full_view) {
	// answer
	$info = '<div>';
	$info .= elgg_get_excerpt((string) $entity->description, 150);
	$info .= elgg_view('output/url', [
		'href' => $entity->getURL(),
		'text' => elgg_echo('user_support:read_more'),
		'class' => 'mlm',
	]);
	$info .= '</div>';
		
	// brief view
	$params = [
		'content' => $info,
		'icon' => false,
	];
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);
} else {
	// full view
	$body = elgg_view('output/longtext', [
		'value' => $entity->description,
	]);

	$params = [
		'icon' => false,
		'body' => $body,
		'show_summary' => true,
	];
	$params = $params + $vars;
	echo elgg_view('object/elements/full', $params);
}
