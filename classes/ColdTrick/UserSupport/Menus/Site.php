<?php

namespace ColdTrick\UserSupport\Menus;

class Site {
	
	/**
	 * Add menu items to the site menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerFAQ($hook, $type, $return_value, $params) {
		
		if (elgg_get_plugin_setting('add_faq_site_menu_item', 'user_support') === 'no') {
			return;
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'faq',
			'icon' => 'question-circle',
			'text' => elgg_echo('user_support:menu:faq'),
			'href' => 'user_support/faq',
		]);
		
		return $return_value;
	}
	
	/**
	 * Add menu items to the site menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerHelpCenter($hook, $type, $return_value, $params) {
		
		if (elgg_get_plugin_setting('add_help_center_site_menu_item', 'user_support') === 'no') {
			return;
		}
		
		$options = [
			'name' => 'help_center',
			'icon' => 'life-ring-regular',
			'text' => elgg_echo('user_support:button:text'),
			'href' => 'user_support/help_center',
		];
		
		if (elgg_get_plugin_setting('show_as_popup', 'user_support') === 'yes') {
			$options['link_class'] = 'elgg-lightbox';
		}
		
		$return_value[] = \ElggMenuItem::factory($options);
		
		return $return_value;
	}
}
