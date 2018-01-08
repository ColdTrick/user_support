<?php

/**
 * Helper class for Help objects
 *
 * @package User_Support
 */
class UserSupportHelp extends ElggObject {
	
	const SUBTYPE = 'help';
	
	/**
	 * {@inheritDoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['access_id'] = ACCESS_PUBLIC;
		$this->attributes['owner_guid'] = $site->guid;
		$this->attributes['container_guid'] = $site->guid;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getURL() {
		return elgg_normalize_url('user_support/help/view/' . $this->guid . '/' . elgg_get_friendly_title($this->getDisplayName()));
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function canComment($user_guid = 0, $default = null) {
		return false;
	}
}
