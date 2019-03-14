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
	public static function registerGroupFAQ($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof \ElggGroup || !user_support_is_group_faq_enabled($entity)) {
			return;
		}
		
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
