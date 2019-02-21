<?php

$title_text = elgg_echo('user_support:help_center:ask');

elgg_push_collection_breadcrumbs('object', 'support_ticket', elgg_get_page_owner_entity());

// page elements
$body_vars = user_support_prepare_ticket_form_vars();
$form = elgg_view_form('user_support/support_ticket/edit', [], $body_vars);

// build page
$page_data = elgg_view_layout('default', [
	'title' => $title_text,
	'content' => $form,
	'filter' => false,
]);

// draw page
echo elgg_view_page($title_text, $page_data);
