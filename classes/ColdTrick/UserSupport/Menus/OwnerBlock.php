<?php

namespace ColdTrick\UserSupport\Menus;

class OwnerBlock {
	
	/**
	 * Add menu items to the owner_block menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:owner_block'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerGroupFAQ(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggGroup || !user_support_is_group_faq_enabled($entity)) {
			return;
		}
		
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'faq',
			'text' => elgg_echo('user_support:menu:faq:group'),
			'href' => elgg_generate_url('collection:object:faq:group', [
				'guid' => $entity->guid,
			]),
		]);
		
		return $return_value;
	}
}
