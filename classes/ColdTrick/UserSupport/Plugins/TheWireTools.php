<?php

namespace ColdTrick\UserSupport\Plugins;

/**
 * Support for TheWire Tools plugin
 */
class TheWireTools {
	
	/**
	 * Prevent Help objects from being shared
	 *
	 * @param \Elgg\Event $event 'reshare', 'object'
	 *
	 * @return null|false
	 */
	public static function blockHelpReshare(\Elgg\Event $event): ?bool {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \UserSupportHelp) {
			return null;
		}
		
		return false;
	}
	
	/**
	 * Prevent Support Ticket objects from being shared
	 *
	 * @param \Elgg\Event $event 'reshare', 'object'
	 *
	 * @return null|false
	 */
	public static function blockTicketReshare(\Elgg\Event $event): ?bool {
		$entity = $event->getEntityParam();
		if (!$entity instanceof \UserSupportTicket) {
			return null;
		}
		
		return false;
	}
}
