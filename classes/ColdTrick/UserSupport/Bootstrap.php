<?php

namespace ColdTrick\UserSupport;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
		
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		
		elgg_register_notification_event('object', \UserSupportTicket::SUBTYPE);
		
		// add a group tool option for FAQ
		$group_faq = elgg_get_plugin_setting('group_faq', 'user_support');
		if ($group_faq !== 'no') {
			elgg()->group_tools->register('faq', [
				'label' => elgg_echo('user_support:group:tool_option'),
				'default_on' => $group_faq === 'yes',
			]);
			
			elgg_extend_view('groups/tool_latest', 'user_support/faq/group_module');
		}
				
		$this->initViews();
		$this->initRegisterEvents();
		$this->initRegisterHooks();
	}

	/**
	 * Init views
	 *
	 * @return void
	 */
	protected function initViews() {
		elgg_extend_view('elgg.css', 'css/user_support/site.css');
		elgg_extend_view('elgg.js', 'js/user_support/site.js');
		elgg_extend_view('page/elements/footer', 'user_support/button');
		elgg_extend_view('forms/comment/save', 'user_support/support_ticket/comment');
	}
	
	/**
	 * Register events
	 *
	 * @return void
	 */
	protected function initRegisterEvents() {
		$events = $this->elgg()->events;
		
		$events->registerHandler('create', 'object', __NAMESPACE__ . '\Comments::supportTicketStatus');
	}
	
	/**
	 * Register plugin hooks
	 *
	 * @return void
	 */
	protected function initRegisterHooks() {
		$hooks = $this->elgg()->hooks;
		
		$hooks->registerHandler('get', 'subscriptions', __NAMESPACE__ . '\Notifications::getSupportTicketCommentSubscribers');
		$hooks->registerHandler('prepare', 'notification:create:object:comment', __NAMESPACE__ . '\Notifications::prepareSupportTicketCommentMessage');
		
		$hooks->registerHandler('get', 'subscriptions', __NAMESPACE__ . '\Notifications::getSupportTicketSubscribers');
		$hooks->registerHandler('prepare', 'notification:create:object:' . \UserSupportTicket::SUBTYPE, __NAMESPACE__ . '\Notifications::prepareSupportTicketMessage');
		
		$hooks->registerHandler('enqueue', 'notification', __NAMESPACE__ . '\Notifications::allowTicketEnqueue', 9999);
		$hooks->registerHandler('enqueue', 'notification', __NAMESPACE__ . '\Notifications::allowTicketCommentEnqueue', 9999);
		
		$hooks->registerHandler('likes:is_likable', 'object:' . \UserSupportFAQ::SUBTYPE, '\Elgg\Values::getTrue');
		
		$hooks->registerHandler('register', 'menu:entity', __NAMESPACE__ . '\Menus\Entity::registerTicket');
		$hooks->registerHandler('register', 'menu:entity', __NAMESPACE__ . '\Menus\Entity::registerHelp');
		$hooks->registerHandler('register', 'menu:entity', __NAMESPACE__ . '\Menus\Entity::promoteCommentToFAQ');
		$hooks->registerHandler('register', 'menu:topbar', __NAMESPACE__ . '\Menus\Topbar::registerUserSupportTickets');
		$hooks->registerHandler('register', 'menu:owner_block', __NAMESPACE__ . '\Menus\OwnerBlock::registerGroupFAQ');
		$hooks->registerHandler('register', 'menu:site', __NAMESPACE__ . '\Menus\Site::registerFAQ');
		$hooks->registerHandler('register', 'menu:site', __NAMESPACE__ . '\Menus\Site::registerHelpCenter');
		$hooks->registerHandler('register', 'menu:page', __NAMESPACE__ . '\Menus\Page::registerFAQ');
		$hooks->registerHandler('register', 'menu:page', __NAMESPACE__ . '\Menus\Page::registerUserSupportTickets');
		$hooks->registerHandler('register', 'menu:footer', __NAMESPACE__ . '\Menus\Footer::registerFAQ');
		$hooks->registerHandler('register', 'menu:user_hover', __NAMESPACE__ . '\Menus\UserHover::registerStaff');
		$hooks->registerHandler('register', 'menu:user_support', __NAMESPACE__ . '\Menus\UserSupport::registerUserSupportTickets');
		$hooks->registerHandler('register', 'menu:user_support', __NAMESPACE__ . '\Menus\UserSupport::registerStaff');
		
		$hooks->registerHandler('entity:url', 'object', __NAMESPACE__ . '\Widgets::widgetURL');
		$hooks->registerHandler('reshare', 'object', __NAMESPACE__ . '\TheWireTools::blockHelpReshare');
		$hooks->registerHandler('reshare', 'object', __NAMESPACE__ . '\TheWireTools::blockTicketReshare');
		$hooks->registerHandler('type_subtypes', 'quicklinks', __NAMESPACE__ . '\QuickLinks::blockHelpLink');
		$hooks->registerHandler('type_subtypes', 'quicklinks', __NAMESPACE__ . '\QuickLinks::blockTicketLink');
		
		// permissions
		$hooks->registerHandler('container_logic_check', 'object', __NAMESPACE__ . '\Permissions::faqLogicCheck');
		$hooks->registerHandler('container_permissions_check', 'object', __NAMESPACE__ . '\Permissions::faqContainerWriteCheck');
		
		$hooks->registerHandler('permissions_check', 'object', __NAMESPACE__ . '\Permissions::editSupportTicket');
		
		$hooks->registerHandler('permissions_check:delete', 'object', __NAMESPACE__ . '\Permissions::deleteSupportTicket');
		$hooks->registerHandler('permissions_check:delete', 'object', __NAMESPACE__ . '\Permissions::deleteHelp');
		$hooks->registerHandler('permissions_check:delete', 'object', __NAMESPACE__ . '\Permissions::deleteFAQ');
		
	}
}
