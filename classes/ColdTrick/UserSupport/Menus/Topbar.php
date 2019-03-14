<?php

namespace ColdTrick\UserSupport\Menus;

class Topbar {
	
	/**
	 * Add menu items to the account dropdown menu in the topbar
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
		if (!$user instanceof \ElggUser) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'support_ticket_mine',
			'text' => elgg_echo('user_support:menu:support_tickets:mine'),
			'icon' => 'question',
			'href' => elgg_generate_url('collection:object:support_ticket:owner', [
				'username' => $user->username,
			]),
			'section' => 'alt',
			'parent_name' => 'account',
		]);
		
		return $return_value;
	}
}
