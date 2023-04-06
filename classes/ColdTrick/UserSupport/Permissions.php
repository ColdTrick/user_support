<?php

namespace ColdTrick\UserSupport;

/**
 * Permission event handler
 */
class Permissions {
	
	/**
	 * Add permissions to support staff
	 *
	 * @param \Elgg\Event $event 'permissions_check', 'object'
	 *
	 * @return null|bool
	 */
	public static function editSupportTicket(\Elgg\Event $event): ?bool {
		if ($event->getValue()) {
			// already have permission
			return null;
		}
		
		$entity = $event->getEntityParam();
		$user = $event->getUserParam();
		if (!$entity instanceof \UserSupportTicket || !$user instanceof \ElggUser) {
			return null;
		}
		
		return user_support_is_support_staff($user->guid);
	}
	
	/**
	 * Prevent FAQ from being created in groups which haven't enabled the feature
	 *
	 * @param \Elgg\Event $event 'container_logic_check', 'object'
	 *
	 * @return null|bool
	 */
	public static function faqLogicCheck(\Elgg\Event $event): ?bool {
		$container = $event->getParam('container');
		$subtype = $event->getParam('subtype');
		if (!$container instanceof \ElggGroup || $subtype !== \UserSupportFAQ::SUBTYPE) {
			return null;
		}
		
		return $container->isToolEnabled('faq');
	}
	
	/**
	 * Can a user create an FAQ
	 *
	 * @param \Elgg\Event $event 'container_permissions_check', 'object'
	 *
	 * @return null|bool
	 */
	public static function faqContainerWriteCheck(\Elgg\Event $event): ?bool {
		$user = $event->getUserParam();
		$subtype = $event->getParam('subtype');
		if ($subtype !== \UserSupportFAQ::SUBTYPE || empty($user)) {
			return null;
		}
		
		$container = $event->getParam('container');
		if ($container instanceof \ElggGroup) {
			return $container->canEdit($user->guid);
		}
		
		return user_support_is_support_staff($user->guid);
	}
	
	/**
	 * Check delete permissions for Support tickets
	 *
	 * @param \Elgg\Event $event 'permissions_check:delete', 'object'
	 *
	 * @return null|bool
	 */
	public static function deleteSupportTicket(\Elgg\Event $event): ?bool {
		$entity = $event->getEntityParam();
		$user = $event->getUserParam();
		if (!$entity instanceof \UserSupportTicket || !$user instanceof \ElggUser) {
			return null;
		}
		
		return user_support_is_support_staff($user->guid);
	}
	
	/**
	 * Check delete permissions for Help
	 *
	 * @param \Elgg\Event $event 'permissions_check:delete', 'object'
	 *
	 * @return null|bool
	 */
	public static function deleteHelp(\Elgg\Event $event): ?bool {
		$entity = $event->getEntityParam();
		$user = $event->getUserParam();
		if (!$entity instanceof \UserSupportHelp || !$user instanceof \ElggUser) {
			return null;
		}
		
		return user_support_is_support_staff($user->guid);
	}
	
	/**
	 * Check delete permissions for FAQ
	 *
	 * @param \Elgg\Event $event 'permissions_check:delete', 'object'
	 *
	 * @return null|bool
	 */
	public static function deleteFAQ(\Elgg\Event $event): ?bool {
		$entity = $event->getEntityParam();
		$user = $event->getUserParam();
		if (!$entity instanceof \UserSupportFAQ || !$user instanceof \ElggUser) {
			return null;
		}
		
		$container = $entity->getContainerEntity();
		if ($container instanceof \ElggGroup && $container->canEdit($user->guid)) {
			// FAQ in group, can also be managed by the group owner
			return true;
		}
		
		return user_support_is_support_staff($user->guid);
	}
}
