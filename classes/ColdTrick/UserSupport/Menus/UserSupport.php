<?php

namespace ColdTrick\UserSupport\Menus;

class UserSupport {
	
	/**
	 * Add menu items to the user_support menu
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
		if (empty($user)) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'mine',
			'text' => elgg_echo('user_support:menu:support_tickets:mine'),
			'href' => elgg_generate_url('collection:object:support_ticket:owner', [
				'username' => $user->username,
			]),
			'priority' => 100,
		]);
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'my_archive',
			'text' => elgg_echo('user_support:menu:support_tickets:mine:archive'),
			'href' => elgg_generate_url('collection:object:support_ticket:owner', [
				'username' => $user->username,
				'status' => \UserSupportTicket::CLOSED,
			]),
			'priority' => 200,
		]);
		
		return $return_value;
	}
	
	/**
	 * Add menu items to the user_support menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerStaff($hook, $type, $return_value, $params) {
		
		if (!user_support_staff_gatekeeper(false)) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'all',
			'text' => elgg_echo('user_support:menu:support_tickets'),
			'href' => elgg_generate_url('collection:object:support_ticket:all'),
			'priority' => 300,
		]);
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'archive',
			'text' => elgg_echo('user_support:menu:support_tickets:archive'),
			'href' => elgg_generate_url('collection:object:support_ticket:archive'),
			'priority' => 400,
		]);
		
		return $return_value;
	}
}
