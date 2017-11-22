<?php

namespace ColdTrick\UserSupport\Menus;

class Footer {
	
	/**
	 * Add menu items to the footer menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerFAQ($hook, $type, $return_value, $params) {
		
		if (elgg_get_plugin_setting('add_faq_footer_menu_item', 'user_support') !== 'yes') {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'faq',
			'text' => elgg_echo('user_support:menu:faq'),
			'href' => 'user_support/faq',
		]);
		
		return $return_value;
	}
}
