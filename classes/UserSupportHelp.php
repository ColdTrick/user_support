<?php 

	class UserSupportHelp extends ElggObject {
		const SUBTYPE = "help";
		
		protected function initialise_attributes() {
			global $CONFIG;
			parent::initialise_attributes();
			
			$this->attributes["subtype"] = self::SUBTYPE;
			$this->attributes["access_id"] = ACCESS_PUBLIC;
			$this->attributes["owner_guid"] = $CONFIG->site_guid;
			$this->attributes["container_guid"] = $CONFIG->site_guid;			
		}
		
		public function getURL(){
			global $CONFIG;
			
			return $CONFIG->wwwroot . "pg/user_support/help/" . $this->getGUID() . "/" . elgg_get_friendly_title($this->title);
		}
		
	}




?>