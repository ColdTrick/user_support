<?php

namespace ColdTrick\UserSupport;

class PluginSettings {

	/**
	 * Save the group config
	 *
	 * @param \Elgg\Hook $hook 'setting', 'plugin'
	 *
	 * @return void|string
	 */
	public static function saveGroup(\Elgg\Hook $hook) {
		if ($hook->getParam('plugin_id') !== 'user_support') {
			return;
		}
		
		if ($hook->getParam('name') !== 'help_group_guid') {
			return;
		}
		
		return $hook->getParam('value')[0];
	}
}
