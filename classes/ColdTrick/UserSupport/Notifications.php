<?php

namespace ColdTrick\UserSupport;

use Elgg\Notifications\NotificationEvent;
use Elgg\Notifications\Notification;

class Notifications {
	
	/**
	 * Add users to the subscribers of a comment notification on a support ticket
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function getSupportTicketCommentSubscribers($hook, $type, $return_value, $params) {
		
		$event = elgg_extract('event', $params);
		if (!$event instanceof NotificationEvent) {
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
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		// get the entity the comment was made on
		$entity = $object->getContainerEntity();
		if (!$entity instanceof \UserSupportTicket) {
			elgg_set_ignore_access($ia);
			
			return;
		}
		
		// restore access
		elgg_set_ignore_access($ia);
		
		// by default notify nobody
		$return_value = [];
		
		// did the user comment or some other admin/staff
		if ($entity->owner_guid !== $actor->guid) {
			// admin or staff
			return $return_value;
		}
		
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
	 * Prepare the message that needs to go to the admins for a comment on a support ticket
	 *
	 * @param string       $hook         the name of the hook
	 * @param string       $type         the type of the hook
	 * @param Notification $return_value current return value
	 * @param array        $params       supplied params
	 *
	 * @return void|Notification
	 */
	public static function prepareSupportTicketCommentMessage($hook, $type, $return_value, $params) {
		
		$event = elgg_extract('event', $params);
		if (!$event instanceof NotificationEvent) {
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
		
		// ignore access
		$ia = elgg_set_ignore_access(true);
		
		// get the entity the comment was made on
		$entity = $object->getContainerEntity();
		if (!$entity instanceof \UserSupportTicket) {
			elgg_set_ignore_access($ia);
			
			return;
		}
		
		// restore access
		elgg_set_ignore_access($ia);
		
		$language = elgg_extract('language', $params);
		
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
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param array  $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|array
	 */
	public static function getSupportTicketSubscribers($hook, $type, $return_value, $params) {
		
		$event = elgg_extract('event', $params);
		if (!$event instanceof NotificationEvent) {
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
	 * @param string       $hook         the name of the hook
	 * @param string       $type         the type of the hook
	 * @param Notification $return_value current return value
	 * @param array        $params       supplied params
	 *
	 * @return void|Notification
	 */
	public static function prepareSupportTicketMessage($hook, $type, $return_value, $params) {
		
		$event = elgg_extract('event', $params);
		if (!$event instanceof NotificationEvent) {
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
		
		$language = elgg_extract('language', $params);
		
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
