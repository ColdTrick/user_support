<?php

namespace ColdTrick\UserSupport;

/**
 * Changes to \ElggWidgets
 */
class Widgets {
	
	/**
	 * Return the widget title url
	 *
	 * @param \Elgg\Event $event 'entity:url', 'object'
	 *
	 * @return null|string
	 */
	public static function widgetURL(\Elgg\Event $event): ?string {
		if (!empty($event->getValue())) {
			return null;
		}
		
		$entity = $event->getEntityParam();
		if (!$entity instanceof \ElggWidget) {
			return null;
		}
		
		$owner = $entity->getOwnerEntity();
		
		switch ($entity->handler) {
			case 'faq':
				$route_name = 'collection:object:faq:all';
				$route_params = [];
				if ($owner instanceof \ElggGroup) {
					$route_name = 'collection:object:faq:group';
					$route_params['guid'] = $owner->guid;
				}
				return elgg_generate_url($route_name, $route_params);
				
			case 'support_ticket':
				$route_params = [];
				if ($entity->filter === \UserSupportTicket::CLOSED) {
					$route_params['status'] = \UserSupportTicket::CLOSED;
				}
				return elgg_generate_url('collection:object:support_ticket:owner', $route_params);
				
			case 'support_staff':
				return elgg_generate_url('collection:object:support_ticket:all');
		}
		
		return null;
	}
}
