<?php

use ColdTrick\UserSupport\StaffGatekeeper;
use Elgg\Router\Middleware\Gatekeeper;
use Elgg\Router\Middleware\GroupPageOwnerGatekeeper;
use Elgg\Router\Middleware\UserPageOwnerGatekeeper;

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '11.3',
	],
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
			'capabilities' => [
				'commentable' => true,
				'searchable' => true,
				'likable' => true,
			],
		],
		[
			'type' => 'object',
			'subtype' => 'help',
			'class' => \UserSupportHelp::class,
			'capabilities' => [
				'commentable' => false,
				'searchable' => true,
			],
		],
		[
			'type' => 'object',
			'subtype' => 'support_ticket',
			'class' => \UserSupportTicket::class,
			'capabilities' => [
				'commentable' => true,
				'searchable' => true,
			],
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
		'user_support/support_ticket/close' => [
			'middleware' => [
				StaffGatekeeper::class,
			],
		],
		'user_support/support_ticket/reopen' => [
			'middleware' => [
				StaffGatekeeper::class,
			],
		],
		'user_support/faq/edit' => [],
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
			'middleware' => [
				GroupPageOwnerGatekeeper::class,
			],
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
			'path' => '/user_support/support_ticket/add/{guid?}',
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
			'middleware' => [
				StaffGatekeeper::class,
			],
		],
		'collection:object:support_ticket:archive' => [
			'path' => '/user_support/support_ticket/archive',
			'resource' => 'user_support/support_ticket/archive',
			'middleware' => [
				StaffGatekeeper::class,
			],
		],
		'collection:user:user:support_staff' => [
			'path' => '/user_support/support_ticket/staff',
			'resource' => 'user_support/support_ticket/staff',
			'middleware' => [
				StaffGatekeeper::class,
			],
		],
		'collection:object:support_ticket:owner' => [
			'path' => '/user_support/support_ticket/owner/{username}/{status?}',
			'resource' => 'user_support/support_ticket/owner',
			'middleware' => [
				Gatekeeper::class,
				UserPageOwnerGatekeeper::class,
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
	'events' => [
		'container_logic_check' => [
			'object' => [
				\ColdTrick\UserSupport\GroupToolContainerLogicCheckFAQ::class => [],
			],
		],
		'container_permissions_check' => [
			'object' => [
				'\ColdTrick\UserSupport\Permissions::faqContainerWriteCheck' => [],
			],
		],
		'create' => [
			'object' => [
				'\ColdTrick\UserSupport\Comments::supportTicketStatus' => [],
			],
		],
		'entity:url' => [
			'object' => [
				'\ColdTrick\UserSupport\Widgets::widgetURL' => [],
			],
		],
		'form:prepare:fields' => [
			'user_support/faq/edit' => [
				\ColdTrick\UserSupport\Forms\PrepareFAQFields::class => [],
			],
			'user_support/help/edit' => [
				\ColdTrick\UserSupport\Forms\PrepareHelpFields::class => [],
			],
			'user_support/support_ticket/edit' => [
				\ColdTrick\UserSupport\Forms\PrepareTicketFields::class => [],
			],
		],
		'get' => [
			'subscriptions' => [
				'\ColdTrick\UserSupport\Notifications::getSupportTicketCommentSubscribers' => [],
			],
		],
		'get_sql' => [
			'access' => [
				'\ColdTrick\UserSupport\Database\Access::addSupportStaffACL' => [],
			],
		],
		'notification_type_subtype' => [
			'tag_tools' => [
				'\ColdTrick\UserSupport\Plugins\TagTools::preventTagNotifications' => [],
			],
		],
		'permissions_check' => [
			'object' => [
				'\ColdTrick\UserSupport\Permissions::editSupportTicket' => [],
			],
		],
		'permissions_check:delete' => [
			'object' => [
				'\ColdTrick\UserSupport\Permissions::deleteFAQ' => [],
				'\ColdTrick\UserSupport\Permissions::deleteHelp' => [],
				'\ColdTrick\UserSupport\Permissions::deleteSupportTicket' => [],
			],
		],
		'prepare' => [
			'notification:create:object:comment' => [
				'\ColdTrick\UserSupport\Notifications::prepareSupportTicketCommentMessage' => [],
			],
		],
		'register' => [
			'menu:entity' => [
				'\ColdTrick\UserSupport\Menus\Entity::promoteCommentToFAQ' => [],
				'\ColdTrick\UserSupport\Menus\Entity::registerHelp' => [],
				'\ColdTrick\UserSupport\Menus\Entity::registerTicket' => [],
			],
			'menu:footer' => [
				'\ColdTrick\UserSupport\Menus\Footer::registerFAQ' => [],
			],
			'menu:owner_block' => [
				'\ColdTrick\UserSupport\Menus\OwnerBlock::registerGroupFAQ' => [],
			],
			'menu:page' => [
				'\ColdTrick\UserSupport\Menus\Page::registerFAQ' => [],
				'\ColdTrick\UserSupport\Menus\Page::registerUserSupportTickets' => [],
			],
			'menu:site' => [
				'\ColdTrick\UserSupport\Menus\Site::registerHelpCenter' => [],
				'\ColdTrick\UserSupport\Menus\Site::registerFAQ' => [],
			],
			'menu:topbar' => [
				'\ColdTrick\UserSupport\Menus\Topbar::registerUserSupportTickets' => [],
			],
			'menu:user_hover' => [
				'\ColdTrick\UserSupport\Menus\UserHover::registerStaff' => [],
			],
			'menu:filter:support_ticket' => [
				'\ColdTrick\UserSupport\Menus\FilterSupportTicket::registerStaff' => [],
				'\ColdTrick\UserSupport\Menus\FilterSupportTicket::registerUserSupportTickets' => [],
			],
		],
		'reshare' => [
			'object' => [
				'\ColdTrick\UserSupport\Plugins\TheWireTools::blockTicketReshare' => [],
				'\ColdTrick\UserSupport\Plugins\TheWireTools::blockHelpReshare' => [],
			],
		],
		'seeds' => [
			'database' => [
				'\ColdTrick\UserSupport\Seeder\FAQs::register' => [],
				'\ColdTrick\UserSupport\Seeder\Helps::register' => [],
				'\ColdTrick\UserSupport\Seeder\SupportTickets::register' => [],
			],
		],
		'setting' => [
			'plugin' => [
				'\ColdTrick\UserSupport\PluginSettings::saveGroup' => [],
			],
		],
		'tool_options' => [
			'group' => [
				'\ColdTrick\UserSupport\Plugins\Groups::registerToolOption' => [],
			],
		],
		'type_subtypes' => [
			'quicklinks' => [
				'\ColdTrick\UserSupport\Plugins\QuickLinks::blockHelpLink' => [],
				'\ColdTrick\UserSupport\Plugins\QuickLinks::blockTicketLink' => [],
			],
		],
		'validate:acl_membership' => [
			'advanced_notifications' => [
				'\ColdTrick\UserSupport\Plugins\AdvancedNotifications::disableAclMembershipValidation' => [],
			],
		],
	],
	'view_extensions' => [
		'elgg.css' => [
			'user_support/site.css' => [],
		],
		'notifications/settings/records' => [
			'user_support/notifications/settings' => [],
		],
		'page/elements/footer' => [
			'user_support/button' => [],
		],
		'forms/comment/save' => [
			'user_support/support_ticket/comment' => [],
		],
	],
	'notifications' => [
		'object' => [
			'support_ticket' => [
				'create' => \ColdTrick\UserSupport\Notifications\CreateSupportTicketEventHandler::class,
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
