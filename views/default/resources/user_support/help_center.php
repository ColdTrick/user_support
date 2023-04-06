<?php

$help_url = elgg_extract('HTTP_REFERER', $_SERVER, '');
$help_context = user_support_get_help_context($help_url);
if (empty($help_context)) {
	$help_context = user_support_get_help_context();
}

$contextual_help_object = false;
if (elgg_get_plugin_setting('help_enabled', 'user_support') === 'yes' && !empty($help_context)) {
	$help = elgg_get_entities([
		'type' => 'object',
		'subtype' => \UserSupportHelp::SUBTYPE,
		'limit' => 1,
		'metadata_name_value_pairs' => [
			'help_context' => $help_context,
		],
	]);
	
	if (!empty($help)) {
		$contextual_help_object = $help[0];
	}
}

$group = null;
if (elgg_is_active_plugin('groups')) {
	$group_guid = (int) elgg_get_plugin_setting('help_group_guid', 'user_support');
	$group = get_entity($group_guid);
	if (!$group instanceof \ElggGroup) {
		$group = null;
	}
}

$faq = '';
$faq_limit = 5;
$faq_options = [
	'type' => 'object',
	'subtype' => \UserSupportFAQ::SUBTYPE,
	'limit' => $faq_limit,
	'metadata_name_value_pairs' => [
		'name' => 'help_context',
		'value' => $help_context,
	],
	'pagination' => false,
	'count' => true,
];

$faq_count = elgg_get_entities($faq_options);
if ($faq_count) {
	$faq = elgg_list_entities($faq_options);
	if ($faq_count > $faq_limit) {
		$faq .= elgg_format_element('div', ['class' => 'elgg-justify-right'], elgg_view('output/url', [
			'text' => elgg_echo('user_support:faq:read_more', [($faq_count - $faq_limit)]),
			'href' => elgg_generate_url('collection:object:faq:context', [
				'help_context' => $help_context,
			]),
		]));
	}
}

$help_center = elgg_view('user_support/help_center', [
	'group' => $group,
	'contextual_help_object' => $contextual_help_object,
	'faq' => $faq,
	'help_url' => $help_url,
	'help_context' => $help_context,
]);

// check if this is popup or not
if (elgg_is_xhr()) {
	$help_enabled = elgg_get_plugin_setting('help_enabled', 'user_support') === 'yes';

	$menu = '';
	if (elgg_is_admin_logged_in() && empty($contextual_help_object) && $help_enabled) {
		$menu = elgg_view('output/url', [
			'icon' => 'plus',
			'text' => elgg_echo('user_support:help_center:help'),
			'href' => false,
			'id' => 'user-support-help-center-add-help',
			'class' => ['elgg-button', 'elgg-button-action'],
		]);
	}

	echo elgg_view_module('info', elgg_echo('user_support:help_center:title'), $help_center, [
		'class' => 'user-support-help-center-popup',
		'menu' => $menu,
	]);
	return;
}

echo elgg_view_page(elgg_echo('user_support:help_center:title'), [
	'content' => $help_center,
	'filter' => false,
]);
