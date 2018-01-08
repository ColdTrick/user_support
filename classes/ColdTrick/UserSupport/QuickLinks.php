<?php

namespace ColdTrick\UserSupport;

class QuickLinks {
	
	/**
	 * Prevent Help objects from being linked
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function blockHelpLink($hook, $type, $return_value, $params) {
		
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
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function blockTicketLink($hook, $type, $return_value, $params) {
		
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
