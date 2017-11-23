<?php

$help_contexts = user_support_find_unique_help_context();
$submit_text = elgg_echo('save');

$entity = elgg_extract('entity', $vars);
if ($entity instanceof UserSupportFAQ) {
	
	$submit_text = elgg_echo('edit');
	
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->guid,
	]);
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'container_guid',
	'value' => (int) elgg_extract('container_guid', $vars),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('user_support:question'),
	'name' => 'title',
	'value' => elgg_extract('title', $vars),
	'required' => true,
]);

echo elgg_view_field([
	'#type' => 'longtext',
	'#label' => elgg_echo('user_support:anwser'),
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

if (elgg_is_admin_logged_in() && !empty($help_contexts)) {
	
	echo elgg_view_field([
		'#type' => 'select',
		'#label' => elgg_echo('user_support:help_context'),
		'name' => 'help_context',
		'value' => elgg_extract('help_context', $vars),
		'options' => $help_contexts,
		'multiple' => true,
		'size' => min(count($help_contexts), 5),
	]);
}

echo elgg_view_field([
	'#type' => 'access',
	'#label' => elgg_echo('access'),
	'name' => 'access_id',
	'value' => (int) elgg_extract('access_id', $vars),
	'entity' => $entity,
	'entity_type' => 'object',
	'entity_subtype' => UserSupportFAQ::SUBTYPE,
	'container_guid' => (int) elgg_extract('container_guid', $vars),
]);

echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:allow_comments'),
	'name' => 'allow_comments',
	'value' => elgg_extract('allow_comments', $vars),
	'options_values' => [
		'no' => elgg_echo('option:no'),
		'yes' => elgg_echo('option:yes'),
	],
]);

// form footer
$footer = elgg_view_field([
	'#type' => 'submit',
	'value' => $submit_text,
]);

elgg_set_form_footer($footer);
