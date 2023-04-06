<?php

namespace ColdTrick\UserSupport\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the page menu
 */
class Page {
	
	/**
	 * Add menu items to the page menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:page'
	 *
	 * @return null|MenuItems
	 */
	public static function registerFAQ(\Elgg\Event $event): ?MenuItems {
		if (!elgg_in_context('user_support')) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'faq',
			'text' => elgg_echo('user_support:menu:faq'),
			'href' => elgg_generate_url('collection:object:faq:all'),
		]);
		
		return $return_value;
	}
	
	/**
	 * Add menu items to the page menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:page'
	 *
	 * @return null|MenuItems
	 */
	public static function registerUserSupportTickets(\Elgg\Event $event): ?MenuItems {
		$user = elgg_get_logged_in_user_entity();
		if (empty($user) || !elgg_in_context('user_support')) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'support_ticket_mine',
			'text' => elgg_echo('user_support:menu:support_tickets:mine'),
			'href' => elgg_generate_url('collection:object:support_ticket:owner', [
				'username' => $user->username,
			]),
		]);
		
		return $return_value;
	}
}
