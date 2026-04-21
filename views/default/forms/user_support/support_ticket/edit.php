<?php

$fields = elgg()->fields->get('object', \UserSupportTicket::SUBTYPE);
if (empty($fields)) {
	return;
}

$entity = elgg_extract('entity', $vars);

foreach ($fields as $field) {
	$name = $field['name'];
	$value = elgg_extract($name, $vars);
	
	switch ($name) {
		case 'help_url':
			if (empty($value)) {
				continue(2);
			}
			break;
	}
	
	$field['value'] = $value;
	
	echo elgg_view_field($field);
}


if ($entity instanceof \UserSupportTicket) {
	echo elgg_view_field([
		'#type' => 'hidden',
		'name' => 'guid',
		'value' => $entity->guid,
	]);
}

// footer
$footer_fields = [];
$footer_fields[] = [
	'#type' => 'submit',
	'text' => elgg_echo('save'),
];
if (elgg_is_xhr()) {
	$footer_fields[] = [
		'#type' => 'button',
		'id' => 'user-support-edit-ticket-cancel',
		'text' => elgg_echo('cancel'),
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
