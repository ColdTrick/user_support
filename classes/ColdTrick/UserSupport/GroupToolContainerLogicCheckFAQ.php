<?php

namespace ColdTrick\UserSupport;

use Elgg\Groups\ToolContainerLogicCheck;

/**
 * Prevent FAQs from being created if the group tool option is disabled
 */
class GroupToolContainerLogicCheckFAQ extends ToolContainerLogicCheck {

	/**
	 * {@inheritdoc}
	 */
	public function getContentType(): string {
		return 'object';
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getContentSubtype(): string {
		return \UserSupportFAQ::SUBTYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getToolName(): string {
		return 'faq';
	}
}
