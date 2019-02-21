<?php

namespace ColdTrick\UserSupport\Menus;

class Title {
	
	/**
	 * Add menu items to the title menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerFAQ($hook, $type, $return_value, $params) {
		
		$user = elgg_get_logged_in_user_entity();
		
		
		$page_owner = elgg_get_page_owner_entity();
		if (!$user->isAdmin() && !($page_owner instanceof \ElggGroup && $page_owner->canEdit())) {
			return;
		}
		
		$container_guid = elgg_get_site_entity()->guid;
		if ($page_owner instanceof \ElggGroup) {
			$container_guid = $page_owner->guid;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'add',
			'text' => elgg_echo('add:object:faq'),
			'href' => "user_support/faq/add/{$container_guid}",
			'link_class' => 'elgg-button elgg-button-action',
		]);
		
		return $return_value;
	}
	
	/**
	 * Add menu items to the title menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerSupportTicket($hook, $type, $return_value, $params) {
		
		$user = elgg_get_logged_in_user_entity();
		if (empty($user) || !elgg_in_context('support_ticket_title')) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'add',
			'text' => elgg_echo('user_support:help_center:ask'),
			'href' => 'user_support/support_ticket/add',
			'link_class' => 'elgg-button elgg-button-action',
		]);
		
		return $return_value;
	}
}
