<?php

use Elgg\Exceptions\Http\EntityPermissionsException;
use Elgg\Exceptions\Http\EntityNotFoundException;

$page_owner = elgg_get_page_owner_entity();
if (empty($page_owner) && empty($vars['guid']) && elgg_is_logged_in()) {
	$page_owner = elgg_get_logged_in_user_entity();
	elgg_set_page_owner_guid($page_owner->guid);
}

if (empty($page_owner)) {
	throw new EntityNotFoundException();
}

if (!$page_owner->canEdit()) {
	throw new EntityPermissionsException();
}

elgg_push_collection_breadcrumbs('object', 'support_ticket', $page_owner);

// page elements
$body_vars = user_support_prepare_ticket_form_vars();
$form = elgg_view_form('user_support/support_ticket/edit', [], $body_vars);

echo elgg_view_page(elgg_echo('user_support:help_center:ask'), [
	'content' => $form,
	'filter' => false,
]);
