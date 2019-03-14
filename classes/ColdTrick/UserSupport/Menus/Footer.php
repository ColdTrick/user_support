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
		
		if (elgg_get_plugin_setting('add_faq_footer_menu_item', 'user_support') === 'no') {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'faq',
			'icon' => 'question-circle',
			'text' => elgg_echo('user_support:menu:faq'),
			'href' => elgg_generate_url('default:object:faq'),
		]);
		
		return $return_value;
	}
}
