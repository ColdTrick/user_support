<?php

namespace ColdTrick\UserSupport;

class Widgets {
	
	/**
	 * Return the widget title url
	 *
	 * @param \Elgg\Hook $hook 'entity:url', 'object'
	 *
	 * @return void|string
	 */
	public static function widgetURL(\Elgg\Hook $hook) {
		
		if (!empty($hook->getValue())) {
			return;
		}
		
		$entity = $hook->getEntityParam();
		if (!$entity instanceof \ElggWidget) {
			return;
		}
		
		$owner = $entity->getOwnerEntity();
		
		switch ($entity->handler) {
			case 'faq':
				$link = 'user_support/faq';
				if ($owner instanceof \ElggGroup) {
					$link .= "/group/{$owner->guid}/all";
				}
				
				return elgg_normalize_url($link);
				break;
			case 'support_ticket':
				$link = "user_support/support_ticket/owner/{$owner->username}";
				if ($entity->filter === \UserSupportTicket::CLOSED) {
					$link .= '/' . \UserSupportTicket::CLOSED;
				}
				
				return elgg_normalize_url($link);
				break;
			case 'support_staff':
				return elgg_normalize_url('user_support/support_ticket');
				break;
		}
	}
}
