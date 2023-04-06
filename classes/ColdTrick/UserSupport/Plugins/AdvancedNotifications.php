<?php

namespace ColdTrick\UserSupport\Plugins;

use Elgg\Notifications\NotificationEvent;

/**
 * Support for the Advanced Notifications plugin
 */
class AdvancedNotifications {
	
	/**
	 * Disable acl membership validation for notifications
	 *
	 * @param \Elgg\Event $event 'validate:acl_membership', 'advanced_notifications'
	 *
	 * @return null|false
	 */
	public static function disableAclMembershipValidation(\Elgg\Event $event): ?bool {
		if (!$event->getValue()) {
			// validation already prevented
			return null;
		}
		
		$notification_event = $event->getParam('event');
		if (!$notification_event instanceof NotificationEvent) {
			return null;
		}
		
		$entity = $notification_event->getObject();
		if (!$entity instanceof \ElggComment && !$entity instanceof \UserSupportTicket) {
			return null;
		}
		
		if ($entity instanceof \ElggComment) {
			$container = $entity->getContainerEntity();
			if (!$container instanceof \UserSupportTicket) {
				return null;
			}
		}
		
		return false;
	}
}
