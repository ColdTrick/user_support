<?php

use Elgg\Database\Clauses\OrderByClause;

user_support_staff_gatekeeper();

$q = get_input('q');

$options = [
	'type' => 'object',
	'subtype' => UserSupportTicket::SUBTYPE,
	'metadata_name_value_pairs' => [
		'status' => UserSupportTicket::OPEN,
	],
	'order_by' => new OrderByClause('e.time_updated', 'desc'),
	'no_results' => true,
];

$getter = 'elgg_get_entities';

if (!empty($q)) {
	$options['query'] = $q;
	$getter = 'elgg_search';
}

elgg_register_title_button('user_support', 'add', 'object', 'support_ticket');

$form_vars = [
	'method' => 'GET',
	'disable_security' => true,
	'action' => 'user_support/support_ticket',
];
$search = elgg_view_form('user_support/support_ticket/search', $form_vars);

$body = elgg_call(ELGG_IGNORE_ACCESS, function() use ($options, $getter) {
	return elgg_list_entities($options, $getter);
});

echo elgg_view_page(elgg_echo('user_support:tickets:list:title'), [
	'content' => $search . $body,
	'filter' => elgg_view_menu('user_support', [
		'class' => 'elgg-tabs',
		'sort_by' => 'priority',
	]),
]);
