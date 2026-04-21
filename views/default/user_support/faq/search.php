<?php
/**
 * Add search field before FAQ listing
 *
 * @uses $vars['page'] current page
 */

$supported_routes = [
	'default:object:faq',
	'collection:object:faq:all',
	'collection:object:faq:search',
];
if (!in_array(elgg_get_current_route_name(), $supported_routes)) {
	return;
}

$filter = (array) get_input('filter');
$filter = array_values($filter); // indexing could be messed up

$form_vars = [
	'action' => elgg_generate_url('collection:object:faq:search'),
	'disable_security' => true,
	'method' => 'GET',
];
$body_vars = [
	'filter' => $filter,
];
echo elgg_view_form('user_support/faq/search', $form_vars, $body_vars);
