<?php

namespace ColdTrick\UserSupport\Menus;

class Footer {
	
	/**
	 * Add menu items to the footer menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:footer'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerFAQ(\Elgg\Hook $hook) {
		
		if (elgg_get_plugin_setting('add_faq_footer_menu_item', 'user_support') === 'no') {
			return;
		}
		
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'faq',
			'icon' => 'question-circle',
			'text' => elgg_echo('user_support:menu:faq'),
			'href' => elgg_generate_url('default:object:faq'),
		]);
		
		return $return_value;
	}
}
