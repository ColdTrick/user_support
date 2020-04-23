<?php

elgg_push_collection_breadcrumbs('object', 'support_ticket', elgg_get_page_owner_entity());

// page elements
$body_vars = user_support_prepare_ticket_form_vars();
$form = elgg_view_form('user_support/support_ticket/edit', [], $body_vars);

echo elgg_view_page(elgg_echo('user_support:help_center:ask'), ['content' => $form]);
