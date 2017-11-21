<?php

/**
 * The helper class to support tickets
 */
class UserSupportTicket extends ElggObject {
	
	const SUBTYPE = 'support_ticket';
	
	const OPEN = 'open';
	const CLOSED = 'closed';
	
	/**
	 * {@inheritDoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['access_id'] = ACCESS_PRIVATE;
		
		$this->status = self::OPEN;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getURL() {
		$title = $this->getDisplayName();
		if (strlen($title) > 50) {
			$title = elgg_get_excerpt($title, 50);
		}
		$title = str_replace('...', '', $title);
		
		return elgg_normalize_url('user_support/support_ticket/' . $this->guid . '/' . elgg_get_friendly_title($title));
	}
	
	/**
	 * Get the status of the ticket
	 *
	 * @return string
	 */
	public function getStatus() {
		$result = self::OPEN;
		
		if ($this->status === self::CLOSED) {
			$result = self::CLOSED;
		}
		
		return $result;
	}
	
	/**
	 * Set the status of the ticket
	 *
	 * @param string $status the new status
	 *
	 * @return bool
	 */
	public function setStatus($status) {
		$result = false;
		
		switch ($status) {
			case self::OPEN:
			case self::CLOSED:
				$this->status = $status;
				$result = true;
				break;
		}
		
		return $result;
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getIconURL($size = 'medium') {
		
		$support_type = strtolower($this->support_type);
		if (!in_array($support_type, ['bug', 'request', 'question'])) {
			$support_type = 'question';
		}
		
		switch ($size) {
			case 'tiny':
				$result = "mod/user_support/_graphics/{$support_type}/tiny.png";
				break;
			default:
				$result = "mod/user_support/_graphics/{$support_type}/small.png";
				break;
		}
		
		return elgg_normalize_url($result);
	}
}
