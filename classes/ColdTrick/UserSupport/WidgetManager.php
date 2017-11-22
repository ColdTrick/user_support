<?php

namespace ColdTrick\UserSupport;

class WidgetManager {
	
	/**
	 * Return the widget title url
	 *
	 * @param string $hook         the name of the hook
	 * @param string $type         the type of the hook
	 * @param string $return_value current return value
	 * @param array  $params       supplied params
	 *
	 * @return void|string
	 */
	public static function widgetURL($hook, $type, $return_value, $params) {
		
		if (!empty($return_value)) {
			return;
		}
		
		$entity = elgg_extract('entity', $params);
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
				$link = "user_support/support_ticket/{$owner->username}";
				if ($entity->filter === \UserSupportTicket::CLOSED) {
					$link .= '/archive';
				}
				
				return elgg_normalize_url($link);
				break;
			case 'support_staff':
				return elgg_normalize_url('user_support/support_ticket');
				break;
		}
	}
}
