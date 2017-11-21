<?php

namespace ColdTrick\UserSupport;

class Upgrade {
	
	/**
	 * Set the correct class handler for FAQ
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied params
	 *
	 * @return void
	 */
	public static function setFAQClass($event, $type, $object) {
		
		if (!get_subtype_id('object', \UserSupportFAQ::SUBTYPE)) {
			add_subtype('object', \UserSupportFAQ::SUBTYPE, \UserSupportFAQ::class);
		} elseif (get_subtype_class('object', \UserSupportFAQ::SUBTYPE) !== \UserSupportFAQ::class) {
			update_subtype('object', \UserSupportFAQ::SUBTYPE, \UserSupportFAQ::class);
		}
	}
	
	/**
	 * Set the correct class handler for Help
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied params
	 *
	 * @return void
	 */
	public static function setHelpClass($event, $type, $object) {
		
		if (!get_subtype_id('object', \UserSupportHelp::SUBTYPE)) {
			add_subtype('object', \UserSupportHelp::SUBTYPE, \UserSupportHelp::class);
		} elseif (get_subtype_class('object', \UserSupportHelp::SUBTYPE) !== \UserSupportHelp::class) {
			update_subtype('object', \UserSupportHelp::SUBTYPE, \UserSupportHelp::class);
		}
	}
	
	/**
	 * Set the correct class handler for Ticket
	 *
	 * @param string $event  the name of the event
	 * @param string $type   the type of the event
	 * @param mixed  $object supplied params
	 *
	 * @return void
	 */
	public static function setTicketClass($event, $type, $object) {
		
		if (!get_subtype_id('object', \UserSupportTicket::SUBTYPE)) {
			add_subtype('object', \UserSupportTicket::SUBTYPE, \UserSupportTicket::class);
		} elseif (get_subtype_class('object', \UserSupportTicket::SUBTYPE) !== \UserSupportTicket::class) {
			update_subtype('object', \UserSupportTicket::SUBTYPE, \UserSupportTicket::class);
		}
	}
}
