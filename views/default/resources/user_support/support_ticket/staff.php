<?php

$body = elgg_list_entities([
	'type' => 'user',
	'metadata_names' => [
		'support_staff',
	],
	'no_results' => elgg_echo('user_support:tickets:staff:no_results'),
]);

echo elgg_view_page(elgg_echo('user_support:tickets:staff:title'), [
	'content' => $body,
	'filter_id' => 'support_ticket',
	'filter_value' => 'staff',
]);
