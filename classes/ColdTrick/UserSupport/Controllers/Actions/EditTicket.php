<?php

namespace ColdTrick\UserSupport\Controllers\Actions;

use Elgg\Controllers\EntityEditAction;

/**
 * Edit a support ticker
 */
class EditTicket extends EntityEditAction {
	
	/**
	 * {@inheritdoc}
	 */
	protected function execute(array $skip_field_names = []): void {
		parent::execute($skip_field_names);
		
		$title = strip_tags((string) $this->entity->description);
		$title = preg_replace('/(&nbsp;)+/', ' ', $title);
		$title = trim($title);
		$title = elgg_get_excerpt($title, 50);
		
		$this->entity->title = $title;
	}
}
