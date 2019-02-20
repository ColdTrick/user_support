<?php

use ColdTrick\UserSupport\Bootstrap;

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'bootstrap' => Bootstrap::class,
	'settings' => [
	],
	'entities' => [
		[
			'type' => 'object',
			'subtype' => \UserSupportFAQ::SUBTYPE,
			'class' => \UserSupportFAQ::class,
			'searchable' => true,
		],
		[
			'type' => 'object',
			'subtype' => \UserSupportHelp::SUBTYPE,
			'class' => \UserSupportHelp::class,
			'searchable' => true,
		],
		[
			'type' => 'object',
			'subtype' => \UserSupportTicket::SUBTYPE,
			'class' => \UserSupportTicket::class,
			'searchable' => true,
		],
	],
	'routes' => [
		
	],
	'actions' => [
		'user_support/help/edit' => [
			'access' => 'admin',
		],
		'user_support/help/delete' => [
			'access' => 'admin',
		],
		'user_support/support_staff' => [
			'access' => 'admin',
		],
		'user_support/support_ticket/edit' => [],
		'user_support/support_ticket/delete' => [],
		'user_support/support_ticket/close' => [],
		'user_support/support_ticket/reopen' => [],
		'user_support/faq/edit' => [],
		'user_support/faq/delete' => [],
	],
	'widgets' => [

	],
];
		