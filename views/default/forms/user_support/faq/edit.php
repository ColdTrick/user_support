<?php

$help_contexts = false;

$metadata = elgg_get_metadata([
	'metadata_name' => 'help_context',
	'type' => 'object',
	'subtypes' => [
		UserSupportFAQ::SUBTYPE,
		UserSupportHelp::SUBTYPE,
		UserSupportTicket::SUBTYPE,
	],
	'limit' => false,
]);

if (!empty($metadata)) {
	// make it into an array
	$help_contexts = [];
	foreach ($metadata as $md) {
		$help_contexts[$md->value] = true;
	}
	
	$help_contexts = array_keys($help_contexts);
	natcasesort($help_contexts);
}

$entity = elgg_extract('entity', $vars);
if ($entity instanceof \UserSupportFAQ) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->guid,
	]);
}

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
		'#help' => elgg_echo('user_support:help_context:help'),
		'name' => 'help_context',
		'value' => elgg_extract('help_context', $vars),
		'options' => $help_contexts,
		'multiple' => true,
		'size' => min(count($help_contexts), 5),
	]);
}

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('user_support:allow_comments'),
	'name' => 'allow_comments',
	'default' => 'no',
	'value' => 'yes',
	'checked' => elgg_extract('allow_comments', $vars) === 'yes',
	'switch' => true,
]);

echo elgg_view_field([
	'#type' => 'access',
	'#label' => elgg_echo('access'),
	'name' => 'access_id',
	'value' => (int) elgg_extract('access_id', $vars),
	'entity' => $entity,
	'entity_type' => 'object',
	'entity_subtype' => \UserSupportFAQ::SUBTYPE,
	'container_guid' => (int) elgg_extract('container_guid', $vars),
]);

echo elgg_view_field([
	'#type' => 'container_guid',
	'entity_type' => 'object',
	'entity_subtype' => \UserSupportFAQ::SUBTYPE,
	'value' => (int) elgg_extract('container_guid', $vars),
]);

// form footer
$footer = elgg_view_field([
	'#type' => 'submit',
	'text' => elgg_echo('save'),
]);

elgg_set_form_footer($footer);
