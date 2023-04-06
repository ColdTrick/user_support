<?php

namespace ColdTrick\UserSupport\Plugins;

/**
 * Support for the Tag Tools plugin
 */
class TagTools {
	
	/**
	 * Prevent tag notifications about support tickets and help pages
	 *
	 * @param \Elgg\Event $event 'notification_type_subtype', 'tag_tools'
	 *
	 * @return array
	 */
	public static function preventTagNotifications(\Elgg\Event $event): array {
		$result = $event->getValue();
		foreach ($result as $type => $subtypes) {
			if ($type !== 'object' || !is_array($subtypes)) {
				continue;
			}
			
			foreach ($subtypes as $index => $subtype) {
				if (!in_array($subtype, [\UserSupportTicket::SUBTYPE, \UserSupportHelp::SUBTYPE])) {
					continue;
				}
				
				unset($result[$type][$index]);
			}
		}
		
		return $result;
	}
}
