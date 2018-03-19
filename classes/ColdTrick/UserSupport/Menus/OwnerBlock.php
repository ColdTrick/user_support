<?php

namespace ColdTrick\UserSupport\Menus;

class OwnerBlock {
	
	/**
	 * Add menu items to the owner_block menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerUserSupportTickets($hook, $type, $return_value, $params) {
		
		$user = elgg_extract('entity', $params);
		if (!$user instanceof \ElggUser || $user->guid !== elgg_get_logged_in_user_guid()) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'support_ticket_mine',
			'text' => elgg_echo('user_support:menu:support_tickets:mine'),
			'href' => "user_support/support_ticket/owner/{$user->username}",
		]);
		
		return $return_value;
	}
	
	/**
	 * Add menu items to the owner_block menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerGroupFAQ($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof \ElggGroup || !user_support_is_group_faq_enabled($entity)) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'faq',
			'text' => elgg_echo('user_support:menu:faq:group'),
			'href' => "user_support/faq/group/{$entity->guid}/all",
		]);
		
		return $return_value;
	}
}
