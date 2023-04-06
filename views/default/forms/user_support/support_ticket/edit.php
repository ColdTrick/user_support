<?php

$entity = elgg_extract('entity', $vars);
if ($entity instanceof \UserSupportTicket) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->guid,
	]);
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'help_context',
	'value' => elgg_extract('help_context', $vars),
]);

echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('user_support:question'),
	'name' => 'description',
	'value' => elgg_extract('description', $vars),
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:support_type'),
	'name' => 'support_type',
	'value' => elgg_extract('support_type', $vars),
	'required' => true,
	'options_values' => [
		'question' => elgg_echo('user_support:support_type:question'),
		'bug' => elgg_echo('user_support:support_type:bug'),
		'request' => elgg_echo('user_support:support_type:request'),
	],
]);

echo elgg_view_field([
	'#type' => 'tags',
	'#label' => elgg_echo('tags'),
	'name' => 'tags',
	'value' => elgg_extract('tags', $vars),
]);

$help_url = elgg_extract('help_url', $vars);
if (!empty($help_url)) {
	echo elgg_view_field([
		'#type' => 'url',
		'#label' => elgg_echo('user_support:url'),
		'name' => 'help_url',
		'value' => $help_url,
	]);
}

// footer
$footer_fields = [];
$footer_fields[] = [
	'#type' => 'submit',
	'value' => elgg_echo('save'),
];
if (elgg_is_xhr()) {
	$footer_fields[] = [
		'#type' => 'button',
		'id' => 'user-support-edit-ticket-cancel',
		'value' => elgg_echo('cancel'),
		'class' => [
			'elgg-button-cancel',
		],
	];
}

$footer = elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => $footer_fields,
]);
elgg_set_form_footer($footer);
