<?php 

	class UserSupportHelp extends ElggObject {
		const SUBTYPE = "help";
		
		protected function initializeAttributes() {
			global $CONFIG;
			parent::initializeAttributes();
			
			$this->attributes["subtype"] = self::SUBTYPE;
			$this->attributes["access_id"] = ACCESS_PUBLIC;
			$this->attributes["owner_guid"] = $CONFIG->site_guid;
			$this->attributes["container_guid"] = $CONFIG->site_guid;			
		}
		
		public function getURL(){
			return elgg_get_site_entity()->url . "user_support/help/" . $this->getGUID() . "/" . elgg_get_friendly_title($this->title);
		}
		
	}
