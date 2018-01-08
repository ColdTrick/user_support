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
		return elgg_normalize_url('user_support/support_ticket/view/' . $this->guid . '/' . elgg_get_friendly_title($this->getDisplayName()));
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getDisplayName() {
		$title = $this->title;
		if (empty($title)) {
			$title = $this->description;
		}
		
		return elgg_get_excerpt($title, 50);
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
	
	public function getSupportType() {
		$support_type = strtolower($this->support_type);
		if (!in_array($support_type, ['bug', 'request', 'question'])) {
			$support_type = 'question';
		}
		
		return $support_type;
	}
}
