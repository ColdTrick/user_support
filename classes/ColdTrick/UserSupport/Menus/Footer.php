<?php

namespace ColdTrick\UserSupport\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the footer menu
 */
class Footer {
	
	/**
	 * Add menu items to the footer menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:footer'
	 *
	 * @return null|MenuItems
	 */
	public static function registerFAQ(\Elgg\Event $event): ?MenuItems {
		if (elgg_get_plugin_setting('add_faq_footer_menu_item', 'user_support') === 'no') {
			return null;
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'faq',
			'icon' => 'question-circle',
			'text' => elgg_echo('user_support:menu:faq'),
			'href' => elgg_generate_url('default:object:faq'),
		]);
		
		return $return_value;
	}
}
