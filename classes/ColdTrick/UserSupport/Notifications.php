<?php

namespace ColdTrick\UserSupport;

use Elgg\Notifications\Notification;
use Elgg\Notifications\SubscriptionNotificationEvent;

/**
 * Notification event listener
 */
class Notifications {
	
	/**
	 * Add users to the subscribers of a comment notification on a support ticket
	 *
	 * @param \Elgg\Event $event 'get', 'subscriptions'
	 *
	 * @return null|array
	 */
	public static function getSupportTicketCommentSubscribers(\Elgg\Event $event): ?array {
		$notification_event = $event->getParam('event');
		if (!$notification_event instanceof SubscriptionNotificationEvent) {
			return null;
		}
		
		if ($notification_event->getAction() !== 'create') {
			return null;
		}
		
		// get object
		$object = $event->getObject();
		if (!$object instanceof \ElggComment) {
			return null;
		}
		
		// get actor
		$actor = $event->getActor();
		if (!$actor instanceof \ElggUser) {
			return null;
		}
		
		// get the entity the comment was made on
		$entity = $object->getContainerEntity();
		if (!$entity instanceof \UserSupportTicket) {
			return null;
		}
		
		// did the user comment or some other admin/staff
		if ($entity->owner_guid !== $actor->guid) {
			// admin or staff, this will notify ticket owner
			return null;
		}
		
		// by default notify nobody
		$return_value = [];
		
		// get all the admins to notify
		$users = user_support_get_admin_notify_users($entity);
		if (empty($users)) {
			return $return_value;
		}
		
		// pass all the guids of the admins/staff
		/* @var $user \ElggUser */
		foreach ($users as $user) {
			$settings = $user->getNotificationSettings('user_support_ticket');
			$settings = array_keys(array_filter($settings));
			if (empty($settings)) {
				continue;
			}
			
			$return_value[$user->guid] = $settings;
		}
		
		return $return_value;
	}
	
	/**
	 * Prepare the message when a comment is made on a support ticket
	 *
	 * @param \Elgg\Event $event 'prepare', 'notification:create:object:comment'
	 *
	 * @return null|Notification
	 */
	public static function prepareSupportTicketCommentMessage(\Elgg\Event $event): ?Notification {
		$notification_event = $event->getParam('event');
		if (!$notification_event instanceof SubscriptionNotificationEvent) {
			return null;
		}
		
		if ($event->getAction() !== 'create') {
			return null;
		}
		
		// get object
		$object = $event->getObject();
		if (!$object instanceof \ElggComment) {
			return null;
		}
		
		// get actor
		$actor = $event->getActor();
		if (!$actor instanceof \ElggUser) {
			return null;
		}
		
		// get the entity the comment was made on
		$entity = $object->getContainerEntity();
		if (!$entity instanceof \UserSupportTicket) {
			return null;
		}
		
		$language = $event->getParam('language');
		
		/* @var $return_value Notification */
		$return_value = $event->getValue();
		
		$return_value->subject = elgg_echo('user_support:notify:admin:updated:subject', [$entity->getDisplayName()], $language);
		$return_value->summary = elgg_echo('user_support:notify:admin:updated:summary', [$entity->getDisplayName()], $language);
		$return_value->body = elgg_echo('user_support:notify:admin:updated:message', [
			$actor->getDisplayName(),
			$entity->getDisplayName(),
			$object->description,
			$entity->getURL(),
		], $language);
		
		return $return_value;
	}
}
