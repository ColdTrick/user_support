<?php

namespace ColdTrick\UserSupport\Notifications;

use Elgg\Notifications\NotificationEventHandler;
use Elgg\Database\QueryBuilder;

/**
 * Notification Event Handler for 'object' 'support_ticket' 'create' action
 */
class CreateSupportTicketEventHandler extends NotificationEventHandler {

	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSubject(\ElggUser $recipient, string $method): string {
		return elgg_echo('user_support:notify:admin:create:subject', [
			$this->event->getObject()->getDisplayName(),
		], $recipient->getLanguage());
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSummary(\ElggUser $recipient, string $method): string {
		return elgg_echo('user_support:notify:admin:create:summary', [
			$this->event->getObject()->getDisplayName(),
		], $recipient->getLanguage());
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationBody(\ElggUser $recipient, string $method): string {
		$entity = $this->event->getObject();
		$actor = $this->event->getActor();
				
		return elgg_echo('user_support:notify:admin:create:message', [
			$actor->getDisplayName(),
			$entity->description,
			$entity->getURL(),
		], $recipient->getLanguage());
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSubscriptions(): array {
		// by default notify nobody
		$result = [];
		
		// get all the admins to notify
		$users = user_support_get_admin_notify_users($this->event->getObject());
		if (empty($users)) {
			return $result;
		}
		
		// pass all the guids of the admins/staff
		/* @var $user \ElggUser */
		foreach ($users as $user) {
			$settings = $user->getNotificationSettings('user_support_ticket');
			$settings = array_keys(array_filter($settings));
			if (empty($settings)) {
				continue;
			}
			
			$result[$user->guid] = $settings;
		}
		
		return $result;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function isConfigurableByUser(): bool {
		return false;
	}
}
