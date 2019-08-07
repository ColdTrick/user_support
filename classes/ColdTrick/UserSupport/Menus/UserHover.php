<?php

namespace ColdTrick\UserSupport\Menus;

class UserHover {
	
	/**
	 * Add menu items to the user_hover menu
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:user_hover'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerStaff(\Elgg\Hook $hook) {
		
		$user = elgg_get_logged_in_user_entity();
		if (empty($user) || !$user->isAdmin()) {
			return;
		}
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggUser || ($entity->guid === $user->guid)) {
			return;
		}
		
		if ($entity->isAdmin()) {
			// admins are always support staff
			return;
		}
		
		$is_staff = user_support_staff_gatekeeper(false, $entity->guid);
		
		$return_value = $hook->getValue();
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'user_support_staff_make',
			'icon' => 'level-up-alt',
			'text' => elgg_echo('user_support:menu:user_hover:make_staff'),
			'href' => elgg_generate_action_url('user_support/support_staff', [
				'guid' =>  $entity->guid,
			]),
			'section' => 'admin',
			'item_class' => $is_staff ? 'hidden' : '',
			'data-toggle' => 'user-support-staff-remove',
		]);
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'user_support_staff_remove',
			'icon' => 'level-down-alt',
			'text' => elgg_echo('user_support:menu:user_hover:remove_staff'),
			'href' => elgg_generate_action_url('user_support/support_staff', [
				'guid' => $entity->guid,
			]),
			'section' => 'admin',
			'item_class' => $is_staff ?: 'hidden',
			'data-toggle' => 'user-support-staff-make',
		]);
		
		return $return_value;
	}
}
