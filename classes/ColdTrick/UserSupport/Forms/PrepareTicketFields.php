<?php

namespace ColdTrick\UserSupport\Forms;

/**
 * Prepare fields for the user_support/support_ticket/edit form
 */
class PrepareTicketFields {
	
	/**
	 * Prepare the fields
	 *
	 * @param \Elgg\Event $event 'form:prepare:fields', 'user_support/support_ticket/edit'
	 *
	 * @return array
	 */
	public function __invoke(\Elgg\Event $event): array {
		$vars = $event->getValue();
		
		$values = [];
		
		$fields = elgg()->fields->get('object', \UserSupportHelp::SUBTYPE);
		foreach ($fields as $field) {
			$default_value = null;
			$name = elgg_extract('name', $field);
			
			switch ($name) {
				case 'description':
					$default_value = (string) get_input('ticket_description');
					break;
					
				case 'help_url':
					$default_value = (string) get_input('ticket_url', elgg_extract('help_url', $vars));
					break;
					
				case 'support_type':
					$default_value = (string) get_input('ticket_type');
					break;
			}
			
			$values[$name] = $default_value;
		}
		
		$overrides = [
			'help_url' => elgg_extract('help_url', $values),
			'help_context' => user_support_get_help_context((string) elgg_extract('help_url', $values)),
		];
		
		// edit
		$entity = elgg_extract('entity', $vars);
		if ($entity instanceof \UserSupportTicket) {
			foreach ($values as $key => $value) {
				if (isset($entity->{$key})) {
					$values[$key] = $entity->{$key};
				}
			}
			
			foreach ($overrides as $key => $value) {
				if (isset($entity->{$key})) {
					$overrides[$key] = $entity->{$key};
				}
			}
		}
		
		return array_merge($values, $vars, $overrides);
	}
}
