<?php

namespace ColdTrick\UserSupport;

use Elgg\WidgetDefinition;

class Widgets {
	
	/**
	 * Register FAQ widget
	 *
	 * @param string             $hook         the name of the hook
	 * @param string             $type         the type of the hook
	 * @param WidgetDefinition[] $return_value current return value
	 * @param array              $params       supplied params
	 *
	 * @return WidgetDefinition[]
	 */
	public static function registerFAQ($hook, $type, $return_value, $params) {
		
		$return_value[] = WidgetDefinition::factory([
			'id' => 'faq',
			'name' => elgg_echo('user_support:widgets:faq:title'),
			'description' => elgg_echo('user_support:widgets:faq:description'),
			'context' => [
				'groups',
			],
		]);
		
		return $return_value;
	}
	
	/**
	 * Register support ticket widget, shows your support tickets (open, closed or all)
	 *
	 * @param string             $hook         the name of the hook
	 * @param string             $type         the type of the hook
	 * @param WidgetDefinition[] $return_value current return value
	 * @param array              $params       supplied params
	 *
	 * @return WidgetDefinition[]
	 */
	public static function registerSupportTicket($hook, $type, $return_value, $params) {
		
		$return_value[] = WidgetDefinition::factory([
			'id' => 'support_ticket',
			'name' => elgg_echo('user_support:widgets:support_ticket:title'),
			'description' => elgg_echo('user_support:widgets:support_ticket:description'),
			'context' => [
				'dashboard',
			],
			'multiple' => true,
		]);
		
		return $return_value;
	}
	
	/**
	 * Register support ticket widget for staff, shows all open tickets
	 *
	 * @param string             $hook         the name of the hook
	 * @param string             $type         the type of the hook
	 * @param WidgetDefinition[] $return_value current return value
	 * @param array              $params       supplied params
	 *
	 * @return void|WidgetDefinition[]
	 */
	public static function registerSupportStaff($hook, $type, $return_value, $params) {
		
		$context = elgg_extract('context', $params);
		if (!in_array($context, ['dashboard', 'admin'])) {
			return;
		}
		
		if (!user_support_staff_gatekeeper(false)) {
			return;
		}
		
		$return_value[] = WidgetDefinition::factory([
			'id' => 'support_staff',
			'name' => elgg_echo('user_support:widgets:support_staff:title'),
			'description' => elgg_echo('user_support:widgets:support_staff:description'),
			'context' => [
				'dashboard',
				'admin',
			],
		]);
		
		return $return_value;
	}
}
