<?php

$fields = [];
$fields[] = [
	'#type' => 'text',
	'name' => 'q',
	'placeholder' => elgg_echo('user_support:help_center:search'),
	'class' => 'user-support-help-center-search-input',
];
$fields[] = [
	'#type' => 'submit',
	'value' => elgg_echo('search'),
	'class' => 'hidden',
];
$fields[] = [
	'#type' => 'reset',
	'value' => elgg_echo('reset'),
	'class' => [
		'elgg-button-cancel',
		'hidden',
	],
];

echo elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => $fields,
]);
