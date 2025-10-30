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
		$comment = $notification_event->getObject();
		if (!$comment instanceof \ElggComment) {
			return null;
		}
		
		// get actor
		$actor = $notification_event->getActor();
		if (!$actor instanceof \ElggUser) {
			return null;
		}
		
		// get the entity the comment was made on
		$ticket = $comment->getContainerEntity();
		if (!$ticket instanceof \UserSupportTicket) {
			return null;
		}
		
		// did the user comment or some other admin/staff
		if ($ticket->owner_guid !== $actor->guid) {
			// admin or staff, this will notify ticket owner
			$return_value = $event->getValue();
			
			$return_value[$ticket->owner_guid] = ['email'];
			
			return $return_value;
		}
		
		// by default notify nobody
		$return_value = [];
		
		// get all the admins to notify
		$users = user_support_get_admin_notify_users($ticket);
		if (empty($users)) {
			return $return_value;
		}
		
		// pass all the guids of the admins/staff
		foreach ($users as $user) {
			$settings = $user->getNotificationSettings('user_support_ticket', true);
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
		
		if ($notification_event->getAction() !== 'create') {
			return null;
		}
		
		// get object
		$comment = $notification_event->getObject();
		if (!$comment instanceof \ElggComment) {
			return null;
		}
		
		// get actor
		$actor = $notification_event->getActor();
		if (!$actor instanceof \ElggUser) {
			return null;
		}
		
		// get the entity the comment was made on
		$ticket = $comment->getContainerEntity();
		if (!$ticket instanceof \UserSupportTicket) {
			return null;
		}
		
		/** @var Notification $return_value */
		$return_value = $event->getValue();
		
		$return_value->subject = elgg_echo('user_support:notify:admin:updated:subject', [$ticket->getDisplayName()]);
		$return_value->summary = elgg_echo('user_support:notify:admin:updated:summary', [$ticket->getDisplayName()]);
		$return_value->body = elgg_echo('user_support:notify:admin:updated:message', [
			$actor->getDisplayName(),
			$ticket->getDisplayName(),
			$comment->description,
			$ticket->getURL(),
		]);
		
		return $return_value;
	}
}
