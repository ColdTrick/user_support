<?php

$fields = elgg()->fields->get('object', \UserSupportFAQ::SUBTYPE);
if (empty($fields)) {
	return;
}

$entity = elgg_extract('entity', $vars);

foreach ($fields as $field) {
	$name = $field['name'];
	
	switch ($name) {
		case 'access_id':
			$field['entity'] = $entity;
			$field['container_guid'] = (int) elgg_extract('container_guid', $vars);
			break;
		
		case 'allow_comments':
			$field['checked'] = elgg_extract('allow_comments', $vars) === 'yes';
			
			echo elgg_view_field($field);
			continue(2);
	}
	
	$field['value'] = elgg_extract($name, $vars);
	
	echo elgg_view_field($field);
}

if ($entity instanceof \UserSupportFAQ) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->guid,
	]);
}

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
