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
		
		$query = get_input('q');
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'mine',
			'text' => elgg_echo('user_support:menu:support_tickets:mine'),
			'href' => elgg_http_add_url_query_elements("user_support/support_ticket/owner/{$user->username}", [
				'q' => $query,
			]),
			'priority' => 100,
		]);
	
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'my_archive',
			'text' => elgg_echo('user_support:menu:support_tickets:mine:archive'),
			'href' => elgg_http_add_url_query_elements("user_support/support_ticket/owner/{$user->username}/" . \UserSupportTicket::CLOSED, [
				'q' => $query,
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
		
		$query = get_input('q');
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'all',
			'text' => elgg_echo('user_support:menu:support_tickets'),
			'href' => elgg_http_add_url_query_elements('user_support/support_ticket', [
				'q' => $query,
			]),
			'priority' => 300,
		]);
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'archive',
			'text' => elgg_echo('user_support:menu:support_tickets:archive'),
			'href' => elgg_http_add_url_query_elements('user_support/support_ticket/archive', [
				'q' => $query,
			]),
			'priority' => 400,
		]);
		
		return $return_value;
	}
}
