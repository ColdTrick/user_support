<?php

namespace ColdTrick\UserSupport\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the site menu
 */
class Site {
	
	/**
	 * Add menu items to the site menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:site'
	 *
	 * @return null|MenuItems
	 */
	public static function registerFAQ(\Elgg\Event $event): ?MenuItems {
		if (elgg_get_plugin_setting('add_faq_site_menu_item', 'user_support') === 'no') {
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
	
	/**
	 * Add menu items to the site menu
	 *
	 * @param \Elgg\Event $event 'register', 'menu:site'
	 *
	 * @return null|MenuItems
	 */
	public static function registerHelpCenter(\Elgg\Event $event): ?MenuItems {
		if (elgg_get_plugin_setting('add_help_center_site_menu_item', 'user_support') === 'no') {
			return null;
		}
		
		$options = [
			'name' => 'help_center',
			'icon' => 'life-ring-regular',
			'text' => elgg_echo('user_support:button:text'),
			'href' => elgg_generate_url('default:user_support:help_center'),
		];
		
		if (elgg_get_plugin_setting('show_as_popup', 'user_support') === 'yes') {
			$options['link_class'] = 'elgg-lightbox';
			$options['data-colorbox-opts'] = json_encode([
				'trapFocus' => false,
			]);
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory($options);
		
		return $return_value;
	}
}
