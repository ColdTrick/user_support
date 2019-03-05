<?php

$group = elgg_extract('group', $vars);
/* @var $contextual_help_object UserSupportHelp */
$contextual_help_object = elgg_extract('contextual_help_object', $vars);
$faq = elgg_extract('faq', $vars);

$user = elgg_get_logged_in_user_entity();

$help_enabled = (bool) (elgg_get_plugin_setting('help_enabled', 'user_support') === 'yes');
if (elgg_is_xhr()) {
	
	echo elgg_view_form('user_support/help_center/search', [
		'action' => 'user_support/search',
		'class' => 'mbs',
	]);

	// action buttons
	$buttons = [];
	if ($user instanceof ElggUser) {
		$buttons[] = [
			'name' => 'ticket:add',
			'text' => elgg_echo('user_support:help_center:ask'),
			'href' => 'javascript:void(0);',
			'id' => 'user-support-help-center-ask',
			'link_class' => ['elgg-button', 'elgg-button-action'],
			'deps' => [
				'user_support/help_center/ticket',
			],
		];
		$buttons[] = [
			'name' => 'ticket:mine',
			'text' => elgg_echo('user_support:menu:support_tickets:mine'),
			'href' => 'user_support/support_ticket/owner/' . $user->username,
			'link_class' => ['elgg-button', 'elgg-button-action'],
		];
	}
	
	$buttons[] = [
		'name' => 'faq',
		'text' => elgg_echo('user_support:menu:faq'),
		'href' => 'user_support/faq',
		'link_class' => ['elgg-button', 'elgg-button-action'],
	];
	
	if ($group instanceof ElggGroup) {
		$buttons[] = [
			'name' => 'group',
			'text' => elgg_echo('user_support:help_center:help_group'),
			'href' => $group->getURL(),
			'link_class' => ['elgg-button', 'elgg-button-action'],
		];
	}
	
	echo elgg_view_menu('help_center', [
		'class' => 'elgg-menu-hz',
		'items' => $buttons,
	]);
}

// content sections
echo elgg_format_element('div', [
	'id' => 'user-support-help-search-result-wrapper',
	'class' => 'hidden',
]);

if (elgg_is_xhr() && $help_enabled) {
	if ($contextual_help_object instanceof UserSupportHelp) {
		$contextual_help = elgg_view_entity($contextual_help_object, [
			'title' => false,
			'full_view' => false,
		]);
		
		echo elgg_view_module('info', elgg_echo('user_support:help_center:help:title'), $contextual_help, [
			'id' => 'user_support_help_center_help',
			'class' => [
				'mbm',
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
