<?php

namespace ColdTrick\UserSupport\Notifications;

use Elgg\Notifications\InstantNotificationEventHandler;

/**
 * Send a confirmation to the ticket owner that their issue was saved
 */
class CreateSupportTicketOwnerHandler extends InstantNotificationEventHandler {
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSubject(\ElggUser $recipient, string $method): string {
		$entity = $this->getEventEntity();
		if (!$entity instanceof \UserSupportTicket) {
			return parent::getNotificationSubject($recipient, $method);
		}
		
		return elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ' . $entity->getDisplayName();
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationSummary(\ElggUser $recipient, string $method): string {
		$entity = $this->getEventEntity();
		if (!$entity instanceof \UserSupportTicket) {
			return parent::getNotificationSummary($recipient, $method);
		}
		
		return elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ' . $entity->getDisplayName();
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationBody(\ElggUser $recipient, string $method): string {
		$entity = $this->getEventEntity();
		if (!$entity instanceof \UserSupportTicket) {
			return parent::getNotificationBody($recipient, $method);
		}
		
		return elgg_echo('user_support:notify:user:create:message', [
			$entity->getURL(),
			elgg_generate_url('collection:object:support_ticket:owner', [
				'username' => $recipient->username,
			]),
		]);
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getNotificationMethods(): array {
		return ['email'];
	}
}
