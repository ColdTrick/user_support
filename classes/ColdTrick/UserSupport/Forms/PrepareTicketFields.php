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
		
		$values = [
			'description' => (string) get_input('ticket_description'),
			'tags' => [],
			'help_url' => elgg_extract('help_url', $vars, ''),
			'support_type' => (string) get_input('ticket_type'),
			'help_context' => user_support_get_help_context(elgg_extract('help_url', $vars, '')),
		];
		
		// edit
		$entity = elgg_extract('entity', $vars);
		if ($entity instanceof \UserSupportTicket) {
			foreach ($values as $key => $value) {
				$values[$key] = $entity->$key;
			}
		}
		
		return array_merge($values, $vars);
	}
}
