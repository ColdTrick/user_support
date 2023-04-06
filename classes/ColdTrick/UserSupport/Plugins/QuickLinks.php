<?php

namespace ColdTrick\UserSupport\Plugins;

/**
 * Support for the QuickLinks plugin
 */
class QuickLinks {
	
	/**
	 * Prevent Help objects from being linked
	 *
	 * @param \Elgg\Event $event 'type_subtypes', 'quicklinks'
	 *
	 * @return null|array
	 */
	public static function blockHelpLink(\Elgg\Event $event): ?array {
		$return_value = $event->getValue();
		$object_subtypes = elgg_extract('object', $return_value);
		if (empty($object_subtypes)) {
			return null;
		}
		
		$index = array_search(\UserSupportHelp::SUBTYPE, $object_subtypes);
		if ($index === false) {
			return null;
		}
		
		unset($object_subtypes[$index]);
		$return_value['object'] = $object_subtypes;
		
		return $return_value;
	}
	
	/**
	 * Prevent Support Ticket objects from being linked
	 *
	 * @param \Elgg\Event $event 'type_subtypes', 'quicklinks'
	 *
	 * @return null|array
	 */
	public static function blockTicketLink(\Elgg\Event $event): ?array {
		$return_value = $event->getValue();
		$object_subtypes = elgg_extract('object', $return_value);
		if (empty($object_subtypes)) {
			return null;
		}
		
		$index = array_search(\UserSupportTicket::SUBTYPE, $object_subtypes);
		if ($index === false) {
			return null;
		}
		
		unset($object_subtypes[$index]);
		$return_value['object'] = $object_subtypes;
		
		return $return_value;
	}
}
