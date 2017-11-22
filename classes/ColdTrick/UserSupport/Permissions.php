<?php

namespace ColdTrick\UserSupport;

class Permissions {
	
	/**
	 * Add permissions to support staff
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|bool
	 */
	public static function staffSupportTicket($hook, $type, $return_value, $params) {
		
		if ($return_value) {
			// already have permission
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		$user = elgg_extract('user', $params);
		if (!$entity instanceof \UserSupportTicket || !$user instanceof \ElggUser) {
			return;
		}
				
		return user_support_staff_gatekeeper(false, $user->guid);
	}
}
