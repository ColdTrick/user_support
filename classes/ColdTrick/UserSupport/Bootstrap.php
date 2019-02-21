<?php

namespace ColdTrick\UserSupport;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
		
	/**
	 * {@inheritdoc}
	 */
	public function init() {
		
		elgg_register_notification_event('object', 'comment');
		elgg_register_notification_event('object', \UserSupportTicket::SUBTYPE);
		
		elgg_register_page_handler('user_support', '\ColdTrick\UserSupport\PageHandler::userSupport');
		
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
		
		$events->registerHandler('create', 'object', '\ColdTrick\UserSupport\Comments::supportTicketStatus');
	}
	
	/**
	 * Register plugin hooks
	 *
	 * @return void
	 */
	protected function initRegisterHooks() {
		$hooks = $this->elgg()->hooks;
		
		$hooks->registerHandler('get', 'subscriptions', '\ColdTrick\UserSupport\Notifications::getSupportTicketCommentSubscribers');
		$hooks->registerHandler('prepare', 'notification:create:object:comment', '\ColdTrick\UserSupport\Notifications::prepareSupportTicketCommentMessage');
		
		$hooks->registerHandler('get', 'subscriptions', '\ColdTrick\UserSupport\Notifications::getSupportTicketSubscribers');
		$hooks->registerHandler('prepare', 'notification:create:object:' . \UserSupportTicket::SUBTYPE, '\ColdTrick\UserSupport\Notifications::prepareSupportTicketMessage');
		
		$hooks->registerHandler('enqueue', 'notification', '\ColdTrick\UserSupport\Notifications::allowTicketEnqueue', 9999);
		$hooks->registerHandler('enqueue', 'notification', '\ColdTrick\UserSupport\Notifications::allowTicketCommentEnqueue', 9999);
		
		
		$hooks->registerHandler('handlers', 'widgets', '\ColdTrick\UserSupport\Widgets::registerFAQ');
		$hooks->registerHandler('handlers', 'widgets', '\ColdTrick\UserSupport\Widgets::registerSupportTicket');
		$hooks->registerHandler('handlers', 'widgets', '\ColdTrick\UserSupport\Widgets::registerSupportStaff');
		
		$hooks->registerHandler('likes:is_likable', 'object:' . \UserSupportFAQ::SUBTYPE, '\Elgg\Values::getTrue');
		
		$hooks->registerHandler('register', 'menu:entity', '\ColdTrick\UserSupport\Menus\Entity::registerTicket');
		$hooks->registerHandler('register', 'menu:entity', '\ColdTrick\UserSupport\Menus\Entity::cleanupTicket', 9999);
		$hooks->registerHandler('register', 'menu:entity', '\ColdTrick\UserSupport\Menus\Entity::registerHelp');
		$hooks->registerHandler('register', 'menu:entity', '\ColdTrick\UserSupport\Menus\Entity::promoteCommentToFAQ');
		$hooks->registerHandler('register', 'menu:owner_block', '\ColdTrick\UserSupport\Menus\OwnerBlock::registerUserSupportTickets');
		$hooks->registerHandler('register', 'menu:owner_block', '\ColdTrick\UserSupport\Menus\OwnerBlock::registerGroupFAQ');
		$hooks->registerHandler('register', 'menu:title', '\ColdTrick\UserSupport\Menus\Title::registerFAQ');
		$hooks->registerHandler('register', 'menu:title', '\ColdTrick\UserSupport\Menus\Title::registerSupportTicket');
		$hooks->registerHandler('register', 'menu:site', '\ColdTrick\UserSupport\Menus\Site::registerFAQ');
		$hooks->registerHandler('register', 'menu:site', '\ColdTrick\UserSupport\Menus\Site::registerHelpCenter');
		$hooks->registerHandler('register', 'menu:site', '\ColdTrick\UserSupport\Menus\Site::registerUserSupportTickets');
		$hooks->registerHandler('register', 'menu:page', '\ColdTrick\UserSupport\Menus\Page::registerFAQ');
		$hooks->registerHandler('register', 'menu:page', '\ColdTrick\UserSupport\Menus\Page::registerUserSupportTickets');
		$hooks->registerHandler('register', 'menu:footer', '\ColdTrick\UserSupport\Menus\Footer::registerFAQ');
		$hooks->registerHandler('register', 'menu:user_hover', '\ColdTrick\UserSupport\Menus\UserHover::registerStaff');
		$hooks->registerHandler('register', 'menu:user_support', '\ColdTrick\UserSupport\Menus\UserSupport::registerUserSupportTickets');
		$hooks->registerHandler('register', 'menu:user_support', '\ColdTrick\UserSupport\Menus\UserSupport::registerStaff');
		
		$hooks->registerHandler('entity:url', 'object', '\ColdTrick\UserSupport\WidgetManager::widgetURL');
		$hooks->registerHandler('reshare', 'object', '\ColdTrick\UserSupport\TheWireTools::blockHelpReshare');
		$hooks->registerHandler('reshare', 'object', '\ColdTrick\UserSupport\TheWireTools::blockTicketReshare');
		$hooks->registerHandler('type_subtypes', 'quicklinks', '\ColdTrick\UserSupport\QuickLinks::blockHelpLink');
		$hooks->registerHandler('type_subtypes', 'quicklinks', '\ColdTrick\UserSupport\QuickLinks::blockTicketLink');
		
		// permissions
		$hooks->registerHandler('container_logic_check', 'object', '\ColdTrick\UserSupport\Permissions::faqLogicCheck');
		$hooks->registerHandler('container_permissions_check', 'object', '\ColdTrick\UserSupport\Permissions::faqContainerWriteCheck');
		
		$hooks->registerHandler('permissions_check', 'object', '\ColdTrick\UserSupport\Permissions::editSupportTicket');
		
		$hooks->registerHandler('permissions_check:delete', 'object', '\ColdTrick\UserSupport\Permissions::deleteSupportTicket');
		$hooks->registerHandler('permissions_check:delete', 'object', '\ColdTrick\UserSupport\Permissions::deleteHelp');
		$hooks->registerHandler('permissions_check:delete', 'object', '\ColdTrick\UserSupport\Permissions::deleteFAQ');
		
	}
}
