<?php

use Elgg\BadRequestException;
use Elgg\EntityPermissionsException;

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner instanceof \ElggGroup) {
	elgg_set_page_owner_guid(elgg_get_site_entity()->guid);
}

$page_owner = elgg_get_page_owner_entity();

if (!($page_owner instanceof \ElggSite || $page_owner instanceof \ElggGroup)) {
	throw new BadRequestException();
}

if (!$page_owner->canWriteToContainer(0, 'object', UserSupportFAQ::SUBTYPE)) {
	throw new EntityPermissionsException();
}

elgg_push_collection_breadcrumbs('object', 'faq');

// allow promotion of comment on UserSupportTicket
$comment_guid = false;
if (elgg_is_admin_logged_in()) {
	$comment_guid = (int) get_input('comment_guid');
}

$body_vars = user_support_prepare_faq_form_vars([
	'comment_guid' => $comment_guid,
]);
$content = elgg_view_form('user_support/faq/edit', [], $body_vars);

echo elgg_view_page(elgg_echo('user_support:faq:create:title'), ['content' => $content]);
