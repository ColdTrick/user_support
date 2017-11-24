<?php

$group = elgg_extract('group', $vars);
/* @var $contextual_help_object UserSupportHelp */
$contextual_help_object = elgg_extract('contextual_help_object', $vars);
$faq = elgg_extract('faq', $vars);

$user = elgg_get_logged_in_user_entity();

$help_enabled = false;
if (elgg_get_plugin_setting('help_enabled', 'user_support') != 'no') {
	$help_enabled = true;
}

echo elgg_view_form('user_support/help_center/search', ['class' => 'mbs']);

// action buttons
$buttons = [];
if ($user instanceof ElggUser) {
	
	echo elgg_format_element('script', [], 'require(["user_support/help_center/ticket"]);');
	
	$buttons[] = [
		'text' => elgg_echo('user_support:help_center:ask'),
		'href' => 'javascript:void(0);',
		'id' => 'user-support-help-center-ask',
	];
	$buttons[] = [
		'text' => elgg_echo('user_support:menu:support_tickets:mine'),
		'href' => 'user_support/support_ticket/owner/' . $user->username,
	];
}

$buttons[] = [
	'text' => elgg_echo('user_support:menu:faq'),
	'href' => 'user_support/faq',
];

if ($group instanceof ElggGroup) {
	$buttons[] = [
		'text' => elgg_echo('user_support:help_center:help_group'),
		'href' => $group->getURL(),
	];
}

if (elgg_is_admin_logged_in() && empty($contextual_help_object) && $help_enabled && elgg_is_xhr()) {
	$buttons[] = [
		'text' => elgg_echo('user_support:help_center:help'),
		'href' => 'javascript:void(0);',
		'id' => 'user-support-help-center-add-help',
	];
}

if (!empty($buttons)) {
	$button_content = '';
	foreach ($buttons as $options) {
		$options['class'] = elgg_extract_class($options, ['elgg-button', 'elgg-button-action', 'mrs']);
		
		$button_content .= elgg_view('output/url', $options);
	}
	
	echo elgg_format_element('div', ['class' => 'mbs'], $button_content);
}

// content sections
if (elgg_is_xhr() && $help_enabled) {
	if ($contextual_help_object instanceof UserSupportHelp) {
		$contextual_help = elgg_view_entity($contextual_help_object, [
			'title' => false,
			'full_view' => false,
		]);
		
		echo elgg_view_module('info', elgg_echo('user_support:help_center:help:title'), $contextual_help, [
			'id' => 'user_support_help_center_help',
			'class' => [
				'mbs',
				'user-support-help-center-section',
			],
		]);
	}
	
	if (elgg_is_admin_logged_in()) {
		echo elgg_format_element('script', [], 'require(["user_support/help_center/help"]);');
		
		$help_vars = user_support_prepare_help_form_vars([
			'entity' => $contextual_help_object,
			'url' => elgg_is_xhr() ? elgg_extract('HTTP_REFERER', $_SERVER) : '',
		]);
		$form = elgg_view_form('user_support/help/edit', null, $help_vars);
		
		$title = elgg_echo('user_support:forms:help:title');
		if ($contextual_help_object instanceof UserSupportHelp) {
			$title = elgg_echo('user_support:forms:help:title:edit');
		}
		echo elgg_view_module('info', $title, $form, [
			'id' => 'user-support-help-edit-form-wrapper',
			'class' => [
				'hidden',
				'mbs',
			],
		]);
	}
}

if (!empty($faq)) {
	echo elgg_view_module('info', elgg_echo('user_support:help_center:faq:title'), $faq, [
		'class' => [
			'mbs',
			'user-support-help-center-section',
		],
	]);
}

if ($user instanceof ElggUser) {
	$support_vars = user_support_prepare_ticket_form_vars($vars);
	$form = elgg_view_form('user_support/support_ticket/edit', [], $support_vars);
	
	echo elgg_view_module('info', elgg_echo('user_support:help_center:ask'), $form, [
		'id' => 'user-support-ticket-edit-form-wrapper',
		'class' => 'hidden mbs',
	]);
}

echo elgg_format_element('div', [
	'id' => 'user_support_help_search_result_wrapper',
	'class' => 'hidden',
]);
