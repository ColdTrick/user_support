<?php 

	class UserSupportFAQ extends ElggObject {
		const SUBTYPE = "faq";
		
		protected function initialise_attributes() {
			global $CONFIG;
			parent::initialise_attributes();
			
			$this->attributes["subtype"] = self::SUBTYPE;
			$this->attributes["owner_guid"] = $CONFIG->site_guid;
			$this->attributes["container_guid"] = $CONFIG->site_guid;
		}
		
		public function getURL(){
			global $CONFIG;
			
			return $CONFIG->wwwroot . "pg/user_support/faq/" . $this->getGUID() . "/" . elgg_get_friendly_title($this->title);
		}
		
		public function getIcon($size = "medium"){
			global $CONFIG;
			
			$result = false;
			
			switch($size){
				case "tiny":
					$result = $CONFIG->wwwroot . "mod/user_support/_graphics/faq/tiny.png";
					break;
				default:
					$result = $CONFIG->wwwroot . "mod/user_support/_graphics/faq/small.png";
					break;
			}
			
			return $result;
		}
	}





?>