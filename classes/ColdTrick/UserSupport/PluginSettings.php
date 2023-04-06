<?php

namespace ColdTrick\UserSupport;

/**
 * Change plugin settings
 */
class PluginSettings {

	/**
	 * Save the group config
	 *
	 * @param \Elgg\Event $event 'setting', 'plugin'
	 *
	 * @return null|string
	 */
	public static function saveGroup(\Elgg\Event $event): ?string {
		if ($event->getParam('plugin_id') !== 'user_support') {
			return null;
		}
		
		if ($event->getParam('name') !== 'help_group_guid') {
			return null;
		}
		
		return $event->getParam('value')[0];
	}
}
