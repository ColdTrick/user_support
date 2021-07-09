<?php

namespace ColdTrick\UserSupport;

class Permissions {
	
	/**
	 * Add permissions to support staff
	 *
	 * @param \Elgg\Hook $hook 'permissions_check', 'object'
	 *
	 * @return void|bool
	 */
	public static function editSupportTicket(\Elgg\Hook $hook) {
		
		if ($hook->getValue()) {
			// already have permission
			return;
		}
		
		$entity = $hook->getEntityParam();
		$user = $hook->getUserParam();
		if (!$entity instanceof \UserSupportTicket || !$user instanceof \ElggUser) {
			return;
		}

		return user_support_staff_gatekeeper(false, $user->guid);
	}
	
	/**
	 * Prevent FAQ from being created in groups which haven't enabled the feature
	 *
	 * @param \Elgg\Hook $hook 'container_logic_check', 'object'
	 *
	 * @return void|bool
	 */
	public static function faqLogicCheck(\Elgg\Hook $hook) {
		
		$container = $hook->getParam('container');
		$subtype = $hook->getParam('subtype');
		if (!$container instanceof \ElggGroup || $subtype !== \UserSupportFAQ::SUBTYPE) {
			return;
		}
		
		return $container->isToolEnabled('faq');
	}
	
	/**
	 * Can a user create an FAQ
	 *
	 * @param \Elgg\Hook $hook 'container_permissions_check', 'object'
	 *
	 * @return void|bool
	 */
	public static function faqContainerWriteCheck(\Elgg\Hook $hook) {
		
		$user = $hook->getUserParam();
		$subtype = $hook->getParam('subtype');
		if ($subtype !== \UserSupportFAQ::SUBTYPE || empty($user)) {
			return;
		}
		
		/* @var $container \ElggEntity */
		$container = $hook->getParam('container');
		if ($container instanceof \ElggGroup) {
			return $container->canEdit($user->guid);
		}
		
		return user_support_staff_gatekeeper(false, $user->guid);
	}
	
	/**
	 * Check delete permissions for Support tickets
	 *
	 * @param \Elgg\Hook $hook 'permissions_check:delete', 'object'
	 *
	 * @return void|bool
	 */
	public static function deleteSupportTicket(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		$user = $hook->getUserParam();
		if (!$entity instanceof \UserSupportTicket || !$user instanceof \ElggUser) {
			return;
		}
		
		return user_support_staff_gatekeeper(false, $user->guid);
	}
	
	/**
	 * Check delete permissions for Help
	 *
	 * @param \Elgg\Hook $hook 'permissions_check:delete', 'object'
	 *
	 * @return void|bool
	 */
	public static function deleteHelp(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		$user = $hook->getUserParam();
		if (!$entity instanceof \UserSupportHelp || !$user instanceof \ElggUser) {
			return;
		}
		
		return user_support_staff_gatekeeper(false, $user->guid);
	}
	
	/**
	 * Check delete permissions for FAQ
	 *
	 * @param \Elgg\Hook $hook 'permissions_check:delete', 'object'
	 *
	 * @return void|bool
	 */
	public static function deleteFAQ(\Elgg\Hook $hook) {
		
		$entity = $hook->getEntityParam();
		$user = $hook->getUserParam();
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
