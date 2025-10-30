<?php

if (elgg_in_context('admin')) {
	return;
}

$show_floating_button = elgg_get_plugin_setting('show_floating_button', 'user_support');
if ($show_floating_button === 'no') {
	return;
}

$help_context = user_support_get_help_context();
$content_count = 0;
if (isset($help_context)) {
	$subtypes = [
		\UserSupportFAQ::SUBTYPE,
	];
	if (elgg_get_plugin_setting('help_enabled', 'user_support') === 'yes') {
		$subtypes[] = \UserSupportHelp::SUBTYPE;
	}
	
	$content_count = elgg_get_entities([
		'type' => 'object',
		'subtypes' => $subtypes,
		'count' => true,
		'metadata_name_value_pairs' => [
			'help_context' => $help_context,
		],
	]);
}

$link_options = [
	'icon_alt' => 'life-ring',
	'text' => elgg_echo('user_support:button:text'),
	'href' => elgg_generate_url('default:user_support:help_center'),
	'class' => [
		'user-support-button-help-center',
	],
];

if ($content_count > 0) {
	$link_options['class'][] = 'elgg-state-active';
}

if (elgg_get_plugin_setting('show_as_popup', 'user_support') === 'yes') {
	$link_options['class'][] = 'elgg-lightbox';
	$link_options['data-colorbox-opts'] = json_encode([
		'trapFocus' => false,
	]);
}

// position settings
$horizontal = 'left';
$vertical = 'top';
$offset = (int) elgg_get_plugin_setting('float_button_offset', 'user_support', 150);

if ($show_floating_button) {
	list($horizontal, $vertical) = explode('|', $show_floating_button);
}

$attr = [
	'id' => 'user-support-button',
	'title' => elgg_echo('user_support:button:hover'),
	'class' => [
		"position-horizontal-{$horizontal}",
		"position-vertical-{$vertical}",
	],
	'style' => "$vertical: {$offset}px;",
];

echo elgg_format_element('div', $attr, elgg_view('output/url', $link_options));
