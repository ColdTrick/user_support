<?php

namespace ColdTrick\UserSupport\Controllers\Actions;

use Elgg\Controllers\EntityEditAction;

/**
 * Edit FAQ entities
 */
class EditFAQ extends EntityEditAction {
	
	/**
	 * {@inheritdoc}
	 */
	protected function execute(array $skip_field_names = []): void {
		parent::execute($skip_field_names);
		
		if ($this->is_new_entity && $this->entity->getContainerEntity() instanceof \ElggGroup) {
			$this->entity->owner_guid = elgg_get_logged_in_user_guid();
		}
	}
}
