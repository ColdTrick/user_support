<?php

namespace ColdTrick\UserSupport\Menus;

class UserHover {
	
	/**
	 * Add menu items to the user_hover menu
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current return value
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerStaff($hook, $type, $return_value, $params) {
		
		$user = elgg_get_logged_in_user_entity();
		if (empty($user) || !$user->isAdmin()) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof \ElggUser || ($entity->guid === $user->guid)) {
			return;
		}
		
		if ($entity->isAdmin()) {
			// admins are always support staff
			return;
		}
		
		$is_staff = user_support_staff_gatekeeper(false, $entity->guid);
		
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
