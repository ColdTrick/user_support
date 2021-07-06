<?php

use ColdTrick\UserSupport\Bootstrap;
use Elgg\Router\Middleware\Gatekeeper;

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '5.1',
	],
	'bootstrap' => Bootstrap::class,
	'settings' => [
		'help_enabled' => 'yes',
		'show_as_popup' => 'yes',
		'add_faq_site_menu_item' => 'yes',
		'add_help_center_site_menu_item' => 'no',
		'add_faq_footer_menu_item' => 'no',
	],
	'entities' => [
		[
			'type' => 'object',
			'subtype' => 'faq',
			'class' => \UserSupportFAQ::class,
			'searchable' => true,
		],
		[
			'type' => 'object',
			'subtype' => 'help',
			'class' => \UserSupportHelp::class,
			'searchable' => true,
		],
		[
			'type' => 'object',
			'subtype' => 'support_ticket',
			'class' => \UserSupportTicket::class,
			'searchable' => true,
		],
	],
	'routes' => [
		'add:object:faq' => [
			'path' => '/user_support/faq/add/{guid}',
			'resource' => 'user_support/faq/add',
			'middleware' => [
				Gatekeeper::class,
			],
		],
		'edit:object:faq' => [
			'path' => '/user_support/faq/edit/{guid}',
			'resource' => 'user_support/faq/edit',
			'middleware' => [
				Gatekeeper::class,
			],
		],
		'view:object:faq' => [
			'path' => '/user_support/faq/view/{guid}/{title?}',
			'resource' => 'user_support/faq/view',
		],
		'collection:object:faq:group' => [
			'path' => '/user_support/faq/group/{guid}',
			'resource' => 'user_support/faq/group',
		],
		'collection:object:faq:context' => [
			'path' => '/user_support/faq/context',
			'resource' => 'user_support/faq/context',
		],
		'collection:object:faq:all' => [
			'path' => '/user_support/faq/list',
			'resource' => 'user_support/faq/list',
		],
		'add:object:support_ticket' => [
			'path' => '/user_support/support_ticket/add/{guid}',
			'resource' => 'user_support/support_ticket/add',
			'middleware' => [
				Gatekeeper::class,
			],
		],
		'edit:object:support_ticket' => [
			'path' => '/user_support/support_ticket/edit/{guid}',
			'resource' => 'user_support/support_ticket/edit',
			'middleware' => [
				Gatekeeper::class,
			],
		],
		'view:object:support_ticket' => [
			'path' => '/user_support/support_ticket/view/{guid}/{title?}',
			'resource' => 'user_support/support_ticket/view',
			'middleware' => [
				Gatekeeper::class,
			],
		],
		'collection:object:support_ticket:all' => [
			'path' => '/user_support/support_ticket/list',
			'resource' => 'user_support/support_ticket/list',
		],
		'collection:object:support_ticket:archive' => [
			'path' => '/user_support/support_ticket/archive',
			'resource' => 'user_support/support_ticket/archive',
		],
		'collection:object:support_ticket:owner' => [
			'path' => '/user_support/support_ticket/owner/{username}/{status?}',
			'resource' => 'user_support/support_ticket/owner',
			'middleware' => [
				Gatekeeper::class,
			],
		],
		'default:user_support:help_center' => [
			'path' => '/user_support/help_center',
			'resource' => 'user_support/help_center',
		],
		'default:user_support:search' => [
			'path' => '/user_support/search',
			'resource' => 'user_support/search',
		],
		'default:object:support_ticket' => [
			'path' => '/user_support/support_ticket',
			'resource' => 'user_support/support_ticket/list',
		],
		'default:object:faq' => [
			'path' => '/user_support/faq',
			'resource' => 'user_support/faq/list',
		],
	],
	'actions' => [
		'user_support/help/edit' => [
			'access' => 'admin',
		],
		'user_support/support_staff' => [
			'access' => 'admin',
		],
		'user_support/support_ticket/edit' => [],
		'user_support/support_ticket/close' => [],
		'user_support/support_ticket/reopen' => [],
		'user_support/faq/edit' => [],
	],
	'hooks' => [
		'setting' => [
			'plugin' => [
				'\ColdTrick\UserSupport\PluginSettings::saveGroup' => [],
			],
		],
	],
	'widgets' => [
		'faq' => [
			'context' => ['groups'],
		],
		'support_ticket' => [
			'context' => ['dashboard'],
			'multiple' => true,
		],
		'support_staff' => [
			'context' => ['dashboard', 'admin'],
		],
	],
];
