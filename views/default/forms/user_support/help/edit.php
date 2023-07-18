<?php

$help_context = elgg_extract('help_context', $vars);
if (empty($help_context)) {
	echo elgg_view('output/longtext', [
		'value' => elgg_echo('user_support:forms:help:no_context'),
	]);
	return;
}

$entity = elgg_extract('entity', $vars);
if ($entity instanceof \UserSupportHelp) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->guid,
	]);
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'help_context',
	'value' => $help_context,
]);

echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('description'),
	'name' => 'description',
	'value' => elgg_extract('description', $vars),
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'tags',
	'#label' => elgg_echo('tags'),
	'name' => 'tags',
	'value' => elgg_extract('tags', $vars),
]);

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
