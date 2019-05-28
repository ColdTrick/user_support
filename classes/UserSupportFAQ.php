<?php

/**
 * The helper class for FAQ objects
 *
 * @package User_Support
 */
class UserSupportFAQ extends ElggObject {
	
	const SUBTYPE = 'faq';
	
	/**
	 * {@inheritDoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['owner_guid'] = $site->guid;
		$this->attributes['container_guid'] = $site->guid;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function canComment($user_guid = 0, $default = null) {
		
		if ($this->allow_comments !== 'yes') {
			return false;
		}
		
		return parent::canComment($user_guid, $default);
	}
}
