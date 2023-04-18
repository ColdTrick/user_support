<?php

namespace ColdTrick\UserSupport;

use Elgg\Groups\ToolContainerLogicCheck;

/**
 * Prevent FAQs from being created if the group tool option is disabled
 */
class GroupToolContainerLogicCheckFAQ extends ToolContainerLogicCheck {

	/**
	 * {@inheritDoc}
	 */
	public function getContentType(): string {
		return 'object';
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getContentSubtype(): string {
		return \UserSupportFAQ::SUBTYPE;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getToolName(): string {
		return 'faq';
	}
}
