<?php

namespace ColdTrick\UserSupport\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the entity menu
 */
class Entity {
	
	/**
	 * Add menu items to the entity menu of a Ticket
	 *
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return null|MenuItems
	 */
	public static function registerTicket(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \UserSupportTicket) {
			return null;
		}
		
		if (!user_support_is_support_staff()) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
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
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return null|MenuItems
	 */
	public static function registerHelp(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \UserSupportHelp) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		if ($entity->canEdit()) {
			$return_value[] = \ElggMenuItem::factory([
				'name' => 'edit',
				'icon' => 'edit',
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
	 * @param \Elgg\Event $event 'register', 'menu:entity'
	 *
	 * @return null|MenuItems
	 */
	public static function promoteCommentToFAQ(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggComment) {
			return null;
		}
		
		$container = $entity->getContainerEntity();
		if (!$container instanceof \UserSupportTicket) {
			return null;
		}
		
		$site = elgg_get_site_entity();
		if (!$site->canWriteToContainer(0, 'object', \UserSupportFAQ::SUBTYPE)) {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'promote',
			'icon' => 'level-up-alt',
			'text' => elgg_echo('user_support:menu:entity:comment_promote'),
			'title' => elgg_echo('user_support:menu:entity:comment_promote:title'),
			'href' => elgg_generate_url('add:object:faq', [
				'guid' => $site->guid,
				'comment_guid' => $entity->guid,
			]),
		]);
		
		return $return_value;
	}
}
