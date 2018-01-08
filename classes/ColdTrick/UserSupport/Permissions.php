<?php

namespace ColdTrick\UserSupport;

class Permissions {
	
	/**
	 * Add permissions to support staff
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|bool
	 */
	public static function editSupportTicket($hook, $type, $return_value, $params) {
		
		if ($return_value) {
			// already have permission
			return;
		}
		
		$entity = elgg_extract('entity', $params);
		$user = elgg_extract('user', $params);
		if (!$entity instanceof \UserSupportTicket || !$user instanceof \ElggUser) {
			return;
		}
				
		return user_support_staff_gatekeeper(false, $user->guid);
	}
	
	/**
	 * Prevent FAQ from being created in groups which haven't enabled the feature
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|bool
	 */
	public static function faqLogicCheck($hook, $type, $return_value, $params) {
		
		$container = elgg_extract('container', $params);
		$subtype = elgg_extract('subtype', $params);
		if (!$container instanceof \ElggGroup || $subtype !== \UserSupportFAQ::SUBTYPE) {
			return;
		}
		
		if ($container->faq_enable === 'yes') {
			return;
		}
		
		return false;
	}
	
	/**
	 * Can a user create an FAQ
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|bool
	 */
	public static function faqContainerWriteCheck($hook, $type, $return_value, $params) {
		
		$user = elgg_extract('user', $params);
		$subtype = elgg_extract('subtype', $params);
		if ($subtype !== \UserSupportFAQ::SUBTYPE || empty($user)) {
			return;
		}
		
		/* @var $container \ElggEntity */
		$container = elgg_extract('container', $params);
		if ($container instanceof \ElggGroup) {
			return $container->canEdit($user->guid);
		}
		
		return user_support_staff_gatekeeper(false, $user->guid);
	}
	
	/**
	 * Check delete permissions for Support tickets
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|bool
	 */
	public static function deleteSupportTicket($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		$user = elgg_extract('user', $params);
		if (!$entity instanceof \UserSupportTicket || !$user instanceof \ElggUser) {
			return;
		}
		
		return user_support_staff_gatekeeper(false, $user->guid);
	}
	
	/**
	 * Check delete permissions for Help
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|bool
	 */
	public static function deleteHelp($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		$user = elgg_extract('user', $params);
		if (!$entity instanceof \UserSupportHelp || !$user instanceof \ElggUser) {
			return;
		}
		
		return user_support_staff_gatekeeper(false, $user->guid);
	}
	
	/**
	 * Check delete permissions for FAQ
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param bool   $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|bool
	 */
	public static function deleteFAQ($hook, $type, $return_value, $params) {
		
		$entity = elgg_extract('entity', $params);
		$user = elgg_extract('user', $params);
		if (!$entity instanceof \UserSupportFAQ || !$user instanceof \ElggUser) {
			return;
		}
		
		$container = $entity->getContainerEntity();
		if ($container instanceof \ElggGroup && $container->canEdit($user->guid)) {
			// FAQ in group, can also be managed by the group owner
			return true;
		}
		
		return user_support_staff_gatekeeper(false, $user->guid);
	}
}
