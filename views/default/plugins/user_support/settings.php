<?php

/* @var $plugin ElggPlugin */
$plugin = elgg_extract('entity', $vars);

// prepare options
$noyes_options = [
	'no' => elgg_echo('option:no'),
	'yes' => elgg_echo('option:yes'),
];

$yesno_options = array_reverse($noyes_options, true);

$floating_button_options = [
	'no' => elgg_echo('option:no'),
	'left|top' => elgg_echo('user_support:settings:help_center:show_floating_button:left_top'),
	'left|bottom' => elgg_echo('user_support:settings:help_center:show_floating_button:left_bottom'),
	'right|top' => elgg_echo('user_support:settings:help_center:show_floating_button:right_top'),
	'right|bottom' => elgg_echo('user_support:settings:help_center:show_floating_button:right_bottom')
];

// Help
$help = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:settings:help:enabled'),
	'name' => 'params[help_enabled]',
	'value' => $plugin->help_enabled,
	'options_values' => $yesno_options,
]);

echo elgg_view_module('inline', elgg_echo('user_support:settings:help:title'), $help);

// help center settings
$float_button_offset = $plugin->float_button_offset;
if (is_null($float_button_offset) || $float_button_offset === false) {
	$float_button_offset = 150;
}

$help_center = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:settings:help_center:add_help_center_site_menu_item'),
	'name' => 'params[add_help_center_site_menu_item]',
	'value' => $plugin->add_help_center_site_menu_item,
	'options_values' => $noyes_options,
]);

$help_center .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:settings:help_center:show_floating_button'),
	'name' => 'params[show_floating_button]',
	'value' => $plugin->show_floating_button,
	'options_values' => $floating_button_options,
]);

$help_center .= elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('user_support:settings:help_center:float_button_offset'),
	'#help' => elgg_echo('user_support:settings:help_center:float_button_offset:help'),
	'name' => 'params[float_button_offset]',
	'value' => (int) $float_button_offset,
]);

$help_center .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:settings:help_center:show_as_popup'),
	'name' => 'params[show_as_popup]',
	'value' => $plugin->show_as_popup,
	'options_values' => $yesno_options,
]);

echo elgg_view_module('inline', elgg_echo('user_support:settings:help_center:title'), $help_center);

// FAQ settings
$faq = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:settings:faq:add_faq_site_menu_item'),
	'name' => 'params[add_faq_site_menu_item]',
	'value' => $plugin->add_faq_site_menu_item,
	'options_values' => $yesno_options,
]);

$faq .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:settings:faq:add_faq_footer_menu_item'),
	'name' => 'params[add_faq_footer_menu_item]',
	'value' => $plugin->add_faq_footer_menu_item,
	'options_values' => $noyes_options,
]);

$faq .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:settings:faq:group_faq'),
	'name' => 'params[group_faq]',
	'value' => $plugin->group_faq ?: 'yes',
	'options_values' => [
		'no' => elgg_echo('option:no'),
		'yes_off' => elgg_echo('user_support:settings:faq:group_faq:yes_off'),
		'yes' => elgg_echo('user_support:settings:faq:group_faq:yes'),
	],
]);

echo elgg_view_module('inline', elgg_echo('user_support:settings:faq:title'), $faq);

// support tickets
$support_tickets = '';
if (elgg_is_active_plugin('groups')) {
	$group_options = [
		'type' => 'group',
		'limit' => false,
		'joins' => [
			'JOIN ' . elgg_get_config('dbprefix') . 'groups_entity ge ON e.guid = ge.guid',
		],
		'order_by' => 'ge.name',
	];
	
	$group_options_value = array(
		0 => elgg_echo('user_support:settings:support_tickets:help_group:none')
	);
	$groups_batch = new ElggBatch('elgg_get_entities', $group_options);
	/* @var $group ElggGroup */
	foreach ($groups_batch as $group) {
		$group_options_value[$group->guid] = $group->getDisplayName();
	}
	
	$support_tickets .= elgg_view_field([
		'#type' => 'select',
		'#label' => elgg_echo('user_support:settings:support_tickets:help_group'),
		'name' => 'params[help_group_guid]',
		'options_values' => $group_options_value,
		'value' => (int) $plugin->help_group_guid,
	]);
}

echo elgg_view_module('inline', elgg_echo('user_support:settings:support_tickets:title'), $support_tickets);
