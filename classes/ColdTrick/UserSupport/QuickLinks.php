<?php

namespace ColdTrick\UserSupport;

class QuickLinks {
	
	/**
	 * Prevent Help objects from being linked
	 *
	 * @param \Elgg\Hook $hook 'type_subtypes', 'quicklinks'
	 *
	 * @return void|array
	 */
	public static function blockHelpLink(\Elgg\Hook $hook) {
		
		$return_value = $hook->getValue();
		$object_subtypes = elgg_extract('object', $return_value);
		if (empty($object_subtypes)) {
			return;
		}
		
		$index = array_search(\UserSupportHelp::SUBTYPE, $object_subtypes);
		if ($index === false) {
			return;
		}
		
		unset($object_subtypes[$index]);
		$return_value['object'] = $object_subtypes;
		
		return $return_value;
	}
	
	/**
	 * Prevent Support Ticket objects from being linked
	 *
	 * @param \Elgg\Hook $hook 'type_subtypes', 'quicklinks'
	 *
	 * @return void|array
	 */
	public static function blockTicketLink(\Elgg\Hook $hook) {
		
		$return_value = $hook->getValue();
		$object_subtypes = elgg_extract('object', $return_value);
		if (empty($object_subtypes)) {
			return;
		}
		
		$index = array_search(\UserSupportTicket::SUBTYPE, $object_subtypes);
		if ($index === false) {
			return;
		}
		
		unset($object_subtypes[$index]);
		$return_value['object'] = $object_subtypes;
		
		return $return_value;
	}
}
