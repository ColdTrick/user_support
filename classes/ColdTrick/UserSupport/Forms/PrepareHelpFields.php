<?php

namespace ColdTrick\UserSupport\Forms;

/**
 * Prepare fields for the user_support/help/edit form
 */
class PrepareHelpFields {
	
	/**
	 * Prepare the fields
	 *
	 * @param \Elgg\Event $event 'form:prepare:fields', 'user_support/help/edit'
	 *
	 * @return array
	 */
	public function __invoke(\Elgg\Event $event): array {
		$vars = $event->getValue();
		
		$values = [
			'description' => '',
			'tags' => [],
			'help_context' => user_support_get_help_context(elgg_extract('help_url', $vars, '')),
		];
		
		// edit
		$entity = elgg_extract('entity', $vars);
		if ($entity instanceof \UserSupportHelp) {
			foreach ($values as $key => $value) {
				$values[$key] = $entity->$key;
			}
		}
		
		return array_merge($values, $vars);
	}
}
