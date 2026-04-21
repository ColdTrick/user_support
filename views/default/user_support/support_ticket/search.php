<?php
/**
 * Search form before support ticket listing
 *
 * @uses $vars['page'] current page being viewed
 */

$supported_routes = [
	'collection:object:support_ticket:all',
	'collection:object:support_ticket:archive',
	'collection:object:support_ticket:owner',
	'collection:object:support_ticket:owner_archive',
];
$route = elgg_get_current_route();
if (!in_array($route?->getName(), $supported_routes)) {
	return;
}

$page = elgg_extract('page', $vars);
$route_params = $route->getMatchedParameters();
unset($route_params['_route']);

$form_vars = [
	'method' => 'GET',
	'disable_security' => true,
	'action' => elgg_generate_url($route->getName(), $route_params),
];
echo elgg_view_form('user_support/support_ticket/search', $form_vars);
