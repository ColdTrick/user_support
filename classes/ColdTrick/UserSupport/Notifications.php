<?php

namespace ColdTrick\UserSupport;

use Elgg\Notifications\Notification;
use Elgg\Notifications\SubscriptionNotificationEvent;

class Notifications {
	
	/**
	 * Add users to the subscribers of a comment notification on a support ticket
	 *
	 * @param \Elgg\Hook $hook 'get', 'subscriptions'
	 *
	 * @return void|array
	 */
	public static function getSupportTicketCommentSubscribers(\Elgg\Hook $hook) {
		
		$event = $hook->getParam('event');
		if (!$event instanceof SubscriptionNotificationEvent) {
			return;
		}
		
		if ($event->getAction() !== 'create') {
			return;
		}
		
		// get object
		$object = $event->getObject();
		if (!$object instanceof \ElggComment) {
			return;
		}
		
		// get actor
		$actor = $event->getActor();
		if (!$actor instanceof \ElggUser) {
			return;
		}
		
		// get the entity the comment was made on
		$entity = $object->getContainerEntity();
		if (!$entity instanceof \UserSupportTicket) {
			return;
		}
		
		// did the user comment or some other admin/staff
		if ($entity->owner_guid !== $actor->guid) {
			// admin or staff, this will notify ticket owner
			return;
		}
		
		// by default notify nobody
		$return_value = [];
		
		// get all the admins to notify
		$users = user_support_get_admin_notify_users($entity);
		if (empty($users) || !is_array($users)) {
			return $return_value;
		}
		
		// pass all the guids of the admins/staff
		/* @var $user \ElggUser */
		foreach ($users as $user) {
			$notification_settings = $user->getNotificationSettings();
			if (empty($notification_settings)) {
				continue;
			}
			
			$methods = array();
			foreach ($notification_settings as $method => $subbed) {
				if ($subbed) {
					$methods[] = $method;
				}
			}
			
			if (!empty($methods)) {
				$return_value[$user->guid] = $methods;
			}
		}
		
		return $return_value;
	}
	
	/**
	 * Prepare the message when a comment is made on a support ticket
	 *
	 * @param \Elgg\Hook $hook 'prepare', 'notification:create:object:comment'
	 *
	 * @return void|Notification
	 */
	public static function prepareSupportTicketCommentMessage(\Elgg\Hook $hook) {
		
		$event = $hook->getParam('event');
		if (!$event instanceof SubscriptionNotificationEvent) {
			return;
		}
		
		if ($event->getAction() !== 'create') {
			return;
		}
		
		// get object
		$object = $event->getObject();
		if (!$object instanceof \ElggComment) {
			return;
		}
		
		// get actor
		$actor = $event->getActor();
		if (!$actor instanceof \ElggUser) {
			return;
		}
		
		// get the entity the comment was made on
		$entity = $object->getContainerEntity();
		if (!$entity instanceof \UserSupportTicket) {
			return;
		}
		
		$language = $hook->getParam('language');
		
		$return_value = $hook->getValue();
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
	
	/**
	 * Add users to the subscribers of a creation notification for a support ticket
	 *
	 * @param \Elgg\Hook $hook 'get', 'subscriptions'
	 *
	 * @return void|array
	 */
	public static function getSupportTicketSubscribers(\Elgg\Hook $hook) {
		
		$event = $hook->getParam('event');
		if (!$event instanceof SubscriptionNotificationEvent) {
			return;
		}
		
		if ($event->getAction() !== 'create') {
			return;
		}
		
		// get object
		$object = $event->getObject();
		if (!$object instanceof \UserSupportTicket) {
			return;
		}
		
		// by default notify nobody
		$return_value = [];
		
		// get all the admins to notify
		$users = user_support_get_admin_notify_users($object);
		if (empty($users) || !is_array($users)) {
			return $return_value;
		}
		
		// pass all the guids of the admins/staff
		/* @var $user \ElggUser */
		foreach ($users as $user) {
			$notification_settings = $user->getNotificationSettings();
			if (empty($notification_settings)) {
				continue;
			}
			
			$methods = array();
			foreach ($notification_settings as $method => $subbed) {
				if ($subbed) {
					$methods[] = $method;
				}
			}
			
			if (!empty($methods)) {
				$return_value[$user->guid] = $methods;
			}
		}
		
		return $return_value;
	}
	
	/**
	 * Prepare the message that needs to go to the admins for a support ticket
	 *
	 * @param \Elgg\Hook $hook 'prepare', 'notification:create:object:support_ticket'
	 *
	 * @return void|Notification
	 */
	public static function prepareSupportTicketMessage(\Elgg\Hook $hook) {
		
		$event = $hook->getParam('event');
		if (!$event instanceof SubscriptionNotificationEvent) {
			return;
		}
		
		if ($event->getAction() !== 'create') {
			return;
		}
		
		// get object
		$object = $event->getObject();
		if (!$object instanceof \UserSupportTicket) {
			return;
		}
		
		// get actor
		$actor = $event->getActor();
		if (!$actor instanceof \ElggUser) {
			return;
		}
		
		$language = $hook->getParam('language');
		
		$return_value = $hook->getValue();
		$return_value->subject = elgg_echo('user_support:notify:admin:create:subject', [$object->getDisplayName()], $language);
		$return_value->summary = elgg_echo('user_support:notify:admin:create:summary', [$object->getDisplayName()], $language);
		$return_value->body = elgg_echo('user_support:notify:admin:create:message', [
			$actor->getDisplayName(),
			$object->description,
			$object->getURL(),
		], $language);
		
		return $return_value;
	}
}
