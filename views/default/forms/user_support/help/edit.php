<?php

$entity = elgg_extract('entity', $vars);
if ($entity instanceof UserSupportHelp) {
	
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
			'value' => elgg_echo('save'),
		],
		[
			'#type' => 'reset',
			'id' => 'user-support-edit-help-cancel',
			'value' => elgg_echo('cancel'),
		],
	],
]);
elgg_set_form_footer($footer);
