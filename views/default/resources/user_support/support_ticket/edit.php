<?php

elgg_gatekeeper();

$guid = (int) elgg_extract('guid', $vars);
elgg_entity_gatekeeper($guid, 'object', UserSupportTicket::SUBTYPE);

/* @var $entity UserSupportTicket */
$entity = get_entity($guid);
if (!$entity->canEdit()) {
	register_error(elgg_echo('limited_access'));
	forward(REFERER);
}

$owner = $entity->getOwnerEntity();

elgg_set_page_owner_guid($owner->guid);

$title_text = $entity->getDisplayName();

// breadcrumb
if ($owner->getGUID() == elgg_get_logged_in_user_guid()) {
	elgg_push_breadcrumb(elgg_echo('user_support:tickets:mine:title'), 'user_support/support_ticket/owner/' . $owner->username);
} else {
	elgg_push_breadcrumb(elgg_echo('user_support:tickets:owner:title', [$owner->getDisplayName()]), 'user_support/support_ticket/owner/' . $owner->username);
}

elgg_push_breadcrumb($title_text, $entity->getURL());
elgg_push_breadcrumb(elgg_echo('edit'));

// build page elements
$body_vars = user_support_prepare_ticket_form_vars([
	'entity' => $entity,
]);
$content = elgg_view_form('user_support/support_ticket/edit', [], $body_vars);

// build page
$page_data = elgg_view_layout('content', [
	'title' => $title_text,
	'content' => $content,
	'filter' => '',
]);

// draw page
echo elgg_view_page($title_text, $page_data);
