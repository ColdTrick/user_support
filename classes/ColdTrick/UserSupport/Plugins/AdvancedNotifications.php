<?php

namespace ColdTrick\UserSupport\Plugins;

use Elgg\Notifications\NotificationEvent;

class AdvancedNotifications {
	
	/**
	 * Disable acl membership validation for notifications
	 *
	 * @param \Elgg\Hook $hook 'validate:acl_membership', 'advanced_notifications'
	 *
	 * @return void|false
	 */
	public static function disableAclMembershipValidation(\Elgg\Hook $hook) {
		
		if (!$hook->getValue()) {
			// validation already prevented
			return;
		}
		
		$event = $hook->getParam('event');
		if (!$event instanceof NotificationEvent) {
			return;
		}
		
		$entity = $event->getObject();
		if (!$entity instanceof \ElggComment && !$entity instanceof \UserSupportTicket) {
			return;
		}
		
		if ($entity instanceof \ElggComment) {
			$container = $entity->getContainerEntity();
			if (!$container instanceof \UserSupportTicket) {
				return;
			}
		}
		
		return false;
	}
}
