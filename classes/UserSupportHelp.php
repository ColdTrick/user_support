<?php

/**
 * Helper class for Help objects
 *
 * @package User_Support
 */
class UserSupportHelp extends ElggObject {
	const SUBTYPE = "help";
	
	/**
	 * Initialize base attributes
	 *
	 * @see ElggObject::initializeAttributes()
	 *
	 * @return void
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes["subtype"] = self::SUBTYPE;
		$this->attributes["access_id"] = ACCESS_PUBLIC;
		$this->attributes["owner_guid"] = elgg_get_config("site_guid");
		$this->attributes["container_guid"] = elgg_get_config("site_guid");
	}
	
	/**
	 * Get the URL for this entity
	 *
	 * @see ElggEntity::getURL()
	 *
	 * @return string
	 */
	public function getURL() {
		return elgg_normalize_url("user_support/help/" . $this->getGUID() . "/" . elgg_get_friendly_title($this->title));
	}
	
}
