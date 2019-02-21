<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof UserSupportFAQ) {
	return;
}

$full_view = (bool) elgg_extract('full_view', $vars, false);

// entity menu
$entity_menu = '';
if (!elgg_in_context('widgets')) {
	$entity_menu = elgg_view_menu('entity', array(
		'entity' => $entity,
		'handler' => 'user_support/faq',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz'
	));
}

if (!$full_view) {
	// summary (listing) view
	// icon
	$icon = elgg_view_entity_icon($entity, 'small');
	
	// anwser
	$info = '<div>';
	$info .= elgg_get_excerpt($entity->description, 150);
	$info .= elgg_view('output/url', [
		'href' => $entity->getURL(),
		'text' => elgg_echo('user_support:read_more'),
		'class' => 'mlm',
	]);
	$info .= '</div>';
	
	$subtext = '';
	$container = $entity->getContainerEntity();
	if ($container instanceof ElggGroup && ($container->getGUID() !== elgg_get_page_owner_guid())) {
		$group_link = elgg_view('output/url', [
			'text' => $container->getDisplayName(),
			'href' => $container->getURL(),
			'is_trusted' => true,
		]);
		$subtext = elgg_echo('byline:ingroup', [$group_link]);
	}
	
	$params = [
		'entity' => $entity,
		'metadata' => $entity_menu,
		'content' => $info,
		'title' => elgg_view('output/url', [
			'href' => $entity->getURL(),
			'text' => $entity->getDisplayName(),
		]),
		'subtitle' => $subtext,
	];
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($icon, $list_body);
} else {
	// full view
	// icon
	$icon = elgg_view_entity_icon($entity, 'tiny');
	
	// summary
	$params = [
		'entity' => $entity,
		'metadata' => $entity_menu,
		'tags' => elgg_view('output/tags', [
			'value' => $entity->tags,
		]),
		'title' => false,
	];
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	
	// body
	$body = elgg_view('output/longtext', [
		'value' => $entity->description,
	]);
	
	// blog
	echo elgg_view('object/elements/full', [
		'summary' => $summary,
		'icon' => $icon,
		'body' => $body,
		'entity' => $entity,
	]);
}
