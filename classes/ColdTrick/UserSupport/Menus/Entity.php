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
	 * Cleanup menu items from the entity menu of a Ticket
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function cleanupTicket($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof \UserSupportTicket) {
			return;
		}
		
		$remove_items = [
			'access',
		];
		
		foreach ($return_value as $index => $menu_item) {
			if (!in_array($menu_item->getName(), $remove_items)) {
				continue;
			}
			
			unset($return_value[$index]);
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
				'href' => 'javascript:void(0);',
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
		
		// because comments on tickets are rendered with elgg_set_ignore_access(true)
		// write permissions are wrong
		$ia = elgg_set_ignore_access(false);
		
		$can_write_faq = $site->canWriteToContainer(0, 'object', \UserSupportFAQ::SUBTYPE);
		
		// restore access
		elgg_set_ignore_access($ia);
		
		if (!$can_write_faq) {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'promote',
			'text' => elgg_echo('user_support:menu:entity:comment_promote'),
			'title' => elgg_echo('user_support:menu:entity:comment_promote:title'),
			'href' => elgg_http_add_url_query_elements("user_support/faq/add/{$site->guid}", [
				'comment_guid' => $entity->guid,
			]),
		]);
		
		return $return_value;
	}
}
