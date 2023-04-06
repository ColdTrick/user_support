<?php

namespace ColdTrick\UserSupport\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the topbar menu
 */
class Topbar {
	
	/**
	 * Add menu items to the account dropdown menu in the topbar
	 *
	 * @param \Elgg\Event $event 'register', 'menu:topbar'
	 *
	 * @return null|MenuItems
	 */
	public static function registerUserSupportTickets(\Elgg\Event $event): ?MenuItems {
		$user = elgg_get_logged_in_user_entity();
		if (!$user instanceof \ElggUser) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'support_ticket_mine',
			'icon' => 'question',
			'text' => elgg_echo('user_support:menu:support_tickets:mine'),
			'href' => elgg_generate_url('collection:object:support_ticket:owner', [
				'username' => $user->username,
			]),
			'section' => 'alt',
			'parent_name' => 'account',
		]);
		
		return $return_value;
	}
}
