<?php 

	class UserSupportTicket extends ElggObject {
		const SUBTYPE = "support_ticket";
		const OPEN = "open";
		const CLOSED = "closed";
		
		protected function initialise_attributes() {
			global $CONFIG;
			parent::initialise_attributes();
			
			$this->attributes["subtype"] = self::SUBTYPE;
			$this->attributes["access_id"] = ACCESS_PRIVATE;
			
			$this->status = self::OPEN;
		}
		
		public function getURL(){
			global $CONFIG;
			
			return $CONFIG->wwwroot . "pg/user_support/support_ticket/" . $this->getGUID() . "/" . elgg_get_friendly_title($this->title);
		}
		
		public function getStatus(){
			$result = self::OPEN;
			
			if($this->status == self::CLOSED){
				$result = self::CLOSED;
			}
			
			return $result;
		}
		
		public function setStatus($status){
			$result = false;
			
			switch($status){
				case self::OPEN:
				case self::CLOSED:
					$this->status = $status;
					$result = true;
					break;
			}
			
			return $result;
		}
		
		public function getIcon($size = "medium"){
			global $CONFIG;
			
			$result = false;
			
			$support_type = strtolower($this->support_type);
			if(!in_array($support_type, array("bug", "request", "question"))){
				$support_type = "question";
			}
			
			switch($size){
				case "tiny":
					$result = $CONFIG->wwwroot . "mod/user_support/_graphics/" . $support_type . "/tiny.png";
					break;
				default:
					$result = $CONFIG->wwwroot . "mod/user_support/_graphics/" . $support_type . "/small.png";
					break;
			}
			
			return $result;
		}
	}




?>