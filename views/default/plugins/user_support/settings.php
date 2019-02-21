<?php

/* @var $plugin ElggPlugin */
$plugin = elgg_extract('entity', $vars);

// Help
$help = elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('user_support:settings:help:enabled'),
	'name' => 'params[help_enabled]',
	'default' => 'no',
	'value' => 'yes',
	'checked' => $plugin->help_enabled === 'yes',
	'switch' => true,
]);

echo elgg_view_module('info', elgg_echo('user_support:settings:help:title'), $help);

// help center settings
$help_center = elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('user_support:settings:help_center:add_help_center_site_menu_item'),
	'name' => 'params[add_help_center_site_menu_item]',
	'default' => 'no',
	'value' => 'yes',
	'checked' => $plugin->add_help_center_site_menu_item === 'yes',
	'switch' => true,
]);

$help_center .= elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('user_support:settings:help_center:show_floating_button'),
	'name' => 'params[show_floating_button]',
	'value' => $plugin->show_floating_button,
	'options_values' => [
		'no' => elgg_echo('option:no'),
		'left|top' => elgg_echo('user_support:settings:help_center:show_floating_button:left_top'),
		'left|bottom' => elgg_echo('user_support:settings:help_center:show_floating_button:left_bottom'),
		'right|top' => elgg_echo('user_support:settings:help_center:show_floating_button:right_top'),
		'right|bottom' => elgg_echo('user_support:settings:help_center:show_floating_button:right_bottom')
	],
]);

$float_button_offset = $plugin->float_button_offset;
if (is_null($float_button_offset) || $float_button_offset === false) {
	$float_button_offset = 150;
}

$help_center .= elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('user_support:settings:help_center:float_button_offset'),
	'#help' => elgg_echo('user_support:settings:help_center:float_button_offset:help'),
	'name' => 'params[float_button_offset]',
	'value' => (int) $float_button_offset,
]);

$help_center .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('user_support:settings:help_center:show_as_popup'),
	'name' => 'params[show_as_popup]',
	'default' => 'no',
	'value' => 'yes',
	'checked' => $plugin->show_as_popup === 'yes',
	'switch' => true,
]);

echo elgg_view_module('info', elgg_echo('user_support:settings:help_center:title'), $help_center);

// FAQ settings
$faq = elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('user_support:settings:faq:add_faq_site_menu_item'),
	'name' => 'params[add_faq_site_menu_item]',
	'default' => 'no',
	'value' => 'yes',
	'checked' => $plugin->add_faq_site_menu_item === 'yes',
	'switch' => true,
]);

$faq .= elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('user_support:settings:faq:add_faq_footer_menu_item'),
	'name' => 'params[add_faq_footer_menu_item]',
	'default' => 'no',
	'value' => 'yes',
	'checked' => $plugin->add_faq_footer_menu_item === 'yes',
	'switch' => true,
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

echo elgg_view_module('info', elgg_echo('user_support:settings:faq:title'), $faq);

// support tickets
if (!elgg_is_active_plugin('groups')) {
	return;
}

$support_tickets = elgg_view_field([
	'#type' => 'grouppicker',
	'#label' => elgg_echo('user_support:settings:support_tickets:help_group'),
	'name' => 'params[help_group_guid]',
	'value' => (int) $plugin->help_group_guid,
	'limit' => 1,
]);

echo elgg_view_module('info', elgg_echo('user_support:settings:support_tickets:title'), $support_tickets);
