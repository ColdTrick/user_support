<?php

/**
 * The helper class for FAQ objects
 *
 * @package User_Support
 */
class UserSupportFAQ extends ElggObject {
	const SUBTYPE = "faq";
	
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
		return elgg_normalize_url("user_support/faq/" . $this->getGUID() . "/" . elgg_get_friendly_title($this->title));
	}
	
	/**
	 * Get the icon URL
	 *
	 * @param string $size the size of the image
	 *
	 * @see ElggEntity::getIconURL()
	 *
	 * @return string
	 */
	public function getIconURL($size = "medium") {
		
		switch ($size) {
			case "tiny":
				$result = "mod/user_support/_graphics/faq/tiny.png";
				break;
			default:
				$result = "mod/user_support/_graphics/faq/small.png";
				break;
		}
		
		return elgg_normalize_url($result);
	}
	
	/**
	 * Can a user comment on this FAQ
	 *
	 * @param int $user_guid the user to check (ignored)
	 *
	 * @return bool
	 */
	public function canComment($user_guid = 0) {
		$result = false;
		
		if ($this->allow_comments == "yes") {
			$result = true;
		}
		
		return $result;
	}
}