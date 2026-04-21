<?php

$fields = elgg()->fields->get('object', \UserSupportHelp::SUBTYPE);
if (empty($fields)) {
	return;
}

$entity = elgg_extract('entity', $vars);

$help_context = elgg_extract('help_context', $vars);
if (empty($help_context)) {
	echo elgg_view_message('error', elgg_view('output/longtext', [
		'value' => elgg_echo('user_support:forms:help:no_context'),
	]));
	return;
}

foreach ($fields as $field) {
	$name = $field['name'];
	
	$field['value'] = elgg_extract($name, $vars);
	
	echo elgg_view_field($field);
}

if ($entity instanceof \UserSupportHelp) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->guid,
	]);
}

// footer
$footer = elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#type' => 'submit',
			'text' => elgg_echo('save'),
		],
		[
			'#type' => 'reset',
			'id' => 'user-support-edit-help-cancel',
			'text' => elgg_echo('cancel'),
		],
	],
]);
elgg_set_form_footer($footer);
