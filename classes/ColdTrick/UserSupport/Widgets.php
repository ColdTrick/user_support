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
				$route_name = 'collection:object:faq:all';
				$route_params = [];
				if ($owner instanceof \ElggGroup) {
					$route_name = 'collection:object:faq:group';
					$route_params['guid'] = $owner->guid;
				}
				
				return elgg_generate_url($route_name, $route_params);
				break;
			case 'support_ticket':
				$route_params = [];
				if ($entity->filter === \UserSupportTicket::CLOSED) {
					$route_params['status'] = \UserSupportTicket::CLOSED;
				}
				
				return elgg_generate_url('collection:object:support_ticket:owner', $route_params);
				break;
			case 'support_staff':
				return elgg_generate_url('collection:object:support_ticket:all');
				break;
		}
	}
}
