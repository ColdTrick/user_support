<?php

namespace ColdTrick\UserSupport;

class TheWireTools {
	
	/**
	 * Prevent Help objects from being shared
	 *
	 * @param \Elgg\Hook $hook 'reshare', 'object'
	 *
	 * @return void|false
	 */
	public static function blockHelpReshare(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \UserSupportHelp) {
			return;
		}
		
		return false;
	}
	
	/**
	 * Prevent Support Ticket objects from being shared
	 *
	 * @param \Elgg\Hook $hook 'reshare', 'object'
	 *
	 * @return void|false
	 */
	public static function blockTicketReshare(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \UserSupportTicket) {
			return;
		}
		
		return false;
	}
}
