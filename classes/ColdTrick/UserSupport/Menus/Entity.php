<?php

namespace ColdTrick\UserSupport\Menus;

class Entity {
	
	/**
	 * Add menu items to the entity menu of a Ticket
	 *
	 * @param string          $hook
	 * @param string          $type
	 * @param \ElggMenuItem[] $return_vaule
	 * @param array           $params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerTicket($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof \UserSupportTicket) {
			return;
		}
		
		if (!user_support_staff_gatekeeper(false)) {
			return;
		}
		
		if ($entity->getStatus() === \UserSupportTicket::OPEN) {
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'status',
				'text' => elgg_echo('close'),
				'href' => elgg_http_add_url_query_elements('action/user_support/support_ticket/close', [
					'guid' => $entity->guid,
				]),
				'is_action' => true,
				'priority' => 200,
			]);
		} else {
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'status',
				'text' => elgg_echo('user_support:reopen'),
				'href' => elgg_http_add_url_query_elements('action/user_support/support_ticket/reopen', [
					'guid' => $entity->guid,
				]),
				'is_action' => true,
				'priority' => 200,
			]);
		}
		
		return $return_value;
	}
	
	/**
	 * Add menu items to the entity menu of a Help
	 *
	 * @param string          $hook
	 * @param string          $type
	 * @param \ElggMenuItem[] $return_vaule
	 * @param array           $params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerHelp($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof \UserSupportHelp) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'edit',
			'text' => elgg_echo('edit'),
			'href' => '#',
			'id' => 'user-support-help-center-edit-help',
			'priority' => 200,
		]);
		
		return $return_value;
	}
}
