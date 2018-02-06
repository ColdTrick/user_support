<?php

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof UserSupportTicket) {
	return;
}

$full_view = (bool) elgg_extract('full_view', $vars);

// entity menu
$entity_menu = '';
if (!elgg_in_context('widgets')) {
	$entity_menu = elgg_view_menu('entity', [
		'entity' => $entity,
		'handler' => 'user_support/support_ticket',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	]);
}

$owner = $entity->getOwnerEntity();

if (!$full_view) {
	// summary (listing) view
	// icon
	$icon = elgg_view_entity_icon($entity, 'small');
	
	// title
	$title = elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ';

	$title .= elgg_view('output/url', [
		'href' => $entity->getURL(),
		'text' => $entity->getDisplayName(),
		'is_trusted' => true,
	]);
	
	// strapline
	$subtitle = elgg_view('page/elements/by_line', $vars);
	
	// last comment by
	$info = '';
	if ($entity->countComments()) {
		$comments = elgg_get_entities([
			'type' => 'object',
			'subtype' => 'comment',
			'limit' => 1,
			'container_guid' => $entity->guid,
		]);
		/* @var $comment ElggComment */
		$comment = elgg_extract(0, $comments);
		
		$comment_owner = $comment->getOwnerEntity();
		$comment_owner_link = elgg_view('output/url', [
			'text' => $comment_owner->getDisplayName(),
			'href' => $comment_owner->getURL(),
			'is_trusted' => true,
		]);
		
		$comment_link = elgg_view('output/url', [
			'text' => elgg_echo('user_support:last_comment'),
			'href' => $comment->getURL(),
			'is_trusted' => true,
		]);
		
		$subtitle .= ' ' . elgg_echo('user_support:support_ticket:by_line:last_comment', [$comment_link, $comment_owner_link]);
	}
	
	$params = [
		'entity' => $entity,
		'metadata' => $entity_menu,
		'content' => $info,
		'subtitle' => $subtitle,
		'title' => $title,
	];
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($icon, $list_body);
} else {
	// full view
	// icon
	$icon = elgg_view_entity_icon($entity, 'tiny');
	
	// strapline
	$subtitle = elgg_view('page/elements/by_line', $vars);
	
	// summary
	$params = [
		'entity' => $entity,
		'metadata' => $entity_menu,
		'subtitle' => $subtitle,
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
