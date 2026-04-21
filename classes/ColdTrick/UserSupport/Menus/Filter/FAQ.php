<?php

namespace ColdTrick\UserSupport\Menus\Filter;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the filter:faq menu
 */
class FAQ {
	
	/**
	 * Add menu items
	 *
	 * @param \Elgg\Event $event 'register', 'menu:filter:faq'
	 *
	 * @return MenuItems|null
	 */
	public function __invoke(\Elgg\Event $event): ?MenuItems {
		$query = get_input('faq_query');
		if (empty($query)) {
			return null;
		}
		
		/** @var MenuItems $result */
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'all',
			'text' => elgg_echo('all'),
			'href' => elgg_generate_url('collection:object:faq:all'),
		]);
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'search',
			'text' => elgg_echo('search'),
			'href' => elgg_generate_url('collection:object:faq:search', [$query]),
		]);
		
		return $result;
	}
}
