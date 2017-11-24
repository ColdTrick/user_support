<?php

namespace ColdTrick\UserSupport;

class TheWireTools {
	
	/**
	 * Prevent Help objects from being shared
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|false
	 */
	public static function blockHelpReshare($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		if (!$entity instanceof \UserSupportHelp) {
			return;
		}
		
		return false;
	}
}
