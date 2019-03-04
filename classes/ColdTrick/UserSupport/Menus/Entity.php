<?php

namespace ColdTrick\UserSupport\Menus;

class Entity {
	
	/**
	 * Add menu items to the entity menu of a Ticket
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerTicket($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof \UserSupportTicket) {
			return;
		}
		
		if (!user_support_staff_gatekeeper(false)) {
			return $return_value;
		}
		
		if ($entity->getStatus() === \UserSupportTicket::OPEN) {
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'status',
				'icon' => 'lock',
				'text' => elgg_echo('close'),
				'href' => elgg_generate_action_url('user_support/support_ticket/close', [
					'guid' => $entity->guid,
				]),
				'priority' => 200,
			]);
		} else {
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'status',
				'icon' => 'undo',
				'text' => elgg_echo('user_support:reopen'),
				'href' => elgg_generate_action_url('user_support/support_ticket/reopen', [
					'guid' => $entity->guid,
				]),
				'priority' => 200,
			]);
		}
		
		return $return_value;
	}
	
	/**
	 * Add menu items to the entity menu of a Help
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerHelp($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof \UserSupportHelp) {
			return;
		}
		
		if ($entity->canEdit()) {
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'edit',
				'text' => elgg_echo('edit'),
				'href' => false,
				'link_class' => 'user-support-help-center-edit-help',
				'priority' => 200,
			]);
		}
		
		return $return_value;
	}
	
	/**
	 * Add menu items to the entity menu of a Comment
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function promoteCommentToFAQ($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof \ElggComment) {
			return;
		}
		
		$container = $entity->getContainerEntity();
		if (!$container instanceof \UserSupportTicket) {
			return;
		}
		
		$site = elgg_get_site_entity();
		if (!$site->canWriteToContainer(0, 'object', \UserSupportFAQ::SUBTYPE)) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'promote',
			'icon' => 'level-up-alt',
			'text' => elgg_echo('user_support:menu:entity:comment_promote'),
			'title' => elgg_echo('user_support:menu:entity:comment_promote:title'),
			'href' => elgg_http_add_url_query_elements("user_support/faq/add/{$site->guid}", [
				'comment_guid' => $entity->guid,
			]),
		]);
		
		return $return_value;
	}
}
