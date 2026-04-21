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
		
		$values = [];
		
		$fields = elgg()->fields->get('object', \UserSupportHelp::SUBTYPE);
		foreach ($fields as $field) {
			$default_value = null;
			$name = elgg_extract('name', $field);
			
			switch ($name) {
				case 'help_context':
					$default_value = user_support_get_help_context((string) elgg_extract('help_url', $vars));
					break;
			}
			
			$values[$name] = $default_value;
		}
		
		// edit
		$entity = elgg_extract('entity', $vars);
		if ($entity instanceof \UserSupportHelp) {
			foreach ($values as $key => $value) {
				if (isset($entity->{$key})) {
					$values[$key] = $entity->{$key};
				}
			}
		}
		
		return array_merge($values, $vars);
	}
}
