<?php

namespace ColdTrick\UserSupport\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the owner_block menu
 */
class OwnerBlock {
	
	/**
	 * Add menu items to the owner_block menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:owner_block'
	 *
	 * @return null|MenuItems
	 */
	public static function registerGroupFAQ(\Elgg\Event $event): ?MenuItems {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggGroup || !$entity->isToolEnabled('faq')) {
			return null;
		}
		
		/** @var MenuItems $retur_value */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'faq',
			'text' => elgg_echo('collection:object:faq:group'),
			'href' => elgg_generate_url('collection:object:faq:group', [
				'guid' => $entity->guid,
			]),
		]);
		
		return $return_value;
	}
}
