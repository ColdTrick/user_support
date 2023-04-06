<?php

$filter = (array) elgg_extract('filter', $vars);
if (!empty($filter)) {
	foreach ($filter as $tag) {
		echo elgg_view_field([
			'#type' => 'hidden',
			'name' => 'filter[]',
			'value' => $tag,
		]);
	}
}

echo elgg_view_field([
	'#type' => 'search',
	'name' => 'faq_query',
	'value' => get_input('faq_query'),
	'placeholder' => elgg_echo('search'),
]);
