<?php

/**
 * The helper class for FAQ objects
 */
class UserSupportFAQ extends \ElggObject {
	
	const SUBTYPE = 'faq';
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['owner_guid'] = $site->guid;
		$this->attributes['container_guid'] = $site->guid;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function canComment(int $user_guid = 0): bool {
		if ($this->allow_comments !== 'yes') {
			return false;
		}
		
		return parent::canComment($user_guid);
	}
}
