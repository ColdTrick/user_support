<?php

namespace ColdTrick\UserSupport\Menus;

class Page {
	
	/**
	 * Add menu items to the page menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerFAQ($hook, $type, $return_value, $params) {
		
		if (!elgg_in_context('user_support')) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'faq',
			'text' => elgg_echo('user_support:menu:faq'),
			'href' => 'user_support/faq',
		]);
		
		return $return_value;
	}
	
	/**
	 * Add menu items to the page menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerUserSupportTickets($hook, $type, $return_value, $params) {
		
		$user = elgg_get_logged_in_user_entity();
		if (empty($user) || !elgg_in_context('user_support')) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'support_ticket_mine',
			'text' => elgg_echo('user_support:menu:support_tickets:mine'),
			'href' => "user_support/support_ticket/owner/{$user->username}",
		]);
		
		return $return_value;
	}
}
