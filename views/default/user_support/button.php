<?php

if (elgg_in_context('admin')) {
	return;
}

$show_floating_button = elgg_get_plugin_setting('show_floating_button', 'user_support', 'no');
if ($show_floating_button === 'no') {
	return;
}

$help_context = user_support_get_help_context();
$contextual_help_object = user_support_get_help_for_context($help_context);

$faq_count = elgg_get_entities_from_metadata([
	'type' => 'object',
	'subtype' => UserSupportFAQ::SUBTYPE,
	'count' => true,
	'metadata_name_value_pairs' => [
		'help_context' => $help_context,
	],
]);

$link_text = '';
foreach (str_split(strtoupper(elgg_echo('user_support:button:text'))) as $char) {
	$link_text .= $char . '<br />';
}

$link_options = [
	'href' => 'user_support/help_center',
	'text' => $link_text,
	'class' => [
		'user-support-button-help-center',
	],
];

if ((!empty($contextual_help_object) && (elgg_get_plugin_setting('help_enabled', 'user_support') != 'no')) || ($help_context !== false && !empty($faq_count))) {
	$link_options['class'][] = 'elgg-state-active';
}

if (elgg_get_plugin_setting('show_as_popup', 'user_support') != 'no') {
	$link_options['class'][] = 'elgg-lightbox';
}

// position settings
$horizontal = 'left';
$vertical = 'top';
$offset = elgg_get_plugin_setting('float_button_offset', 'user_support');
if (is_null($offset) || $offset === false) {
	$offset = 150;
}
$offset = sanitise_int($offset);

if ($show_floating_button) {
	list($horizontal, $vertical) = explode('|', $show_floating_button);
}

$attr = [
	'id' => 'user-support-button',
	'title' => elgg_echo('user_support:button:hover'),
	'style' => "$horizontal: 0; $vertical: {$offset}px;",
];

echo elgg_format_element('div', $attr, elgg_view('output/url', $link_options));
