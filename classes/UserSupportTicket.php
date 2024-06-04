<?php

use Elgg\Exceptions\InvalidArgumentException;

/**
 * The helper class to support tickets
 *
 * @property string $help_context help context where this ticket was logged
 * @property string $help_url     URL where the ticket was logged
 * @property string $status       status of the ticket (open|closed)
 * @property string $support_type type of the ticket
 */
class UserSupportTicket extends \ElggObject {
	
	const SUBTYPE = 'support_ticket';
	
	const OPEN = 'open';
	const CLOSED = 'closed';
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['access_id'] = ACCESS_PRIVATE;
		
		$this->status = self::OPEN;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function getDisplayName(): string {
		$title = $this->title;
		if (empty($title)) {
			$title = (string) $this->description;
		}
		
		return elgg_get_excerpt($title, 50);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function save(): bool {
		// make sure the ticket has the correct access_id
		if ($this->access_id === ACCESS_PRIVATE) {
			$acl = $this->getAccessCollection();
			if (!$acl instanceof \ElggAccessCollection) {
				throw new InvalidArgumentException('Unable to set correct access level for support ticket');
			}
			
			$this->access_id = $acl->id;
		}
		
		return parent::save();
	}
	
	/**
	 * Get the status of the ticket
	 *
	 * @return string
	 */
	public function getStatus(): string {
		if ($this->status === self::CLOSED) {
			return self::CLOSED;
		}
		
		return self::OPEN;
	}
	
	/**
	 * Set the status of the ticket
	 *
	 * @param string $status the new status
	 *
	 * @return bool
	 */
	public function setStatus(string $status): bool {
		switch ($status) {
			case self::OPEN:
			case self::CLOSED:
				$this->status = $status;
				
				return true;
		}
		
		return false;
	}
	
	/**
	 * Get the type of the support ticket
	 *
	 * @return string
	 */
	public function getSupportType(): string {
		$support_type = strtolower($this->support_type);
		if (!in_array($support_type, ['bug', 'request', 'question'])) {
			$support_type = 'question';
		}
		
		return $support_type;
	}
	
	/**
	 * Get an access collection for this support ticket (created if not already exists)
	 *
	 * @return \ElggAccessCollection|null
	 */
	protected function getAccessCollection(): ?\ElggAccessCollection {
		$owner = $this->getOwnerEntity();
		if (!$owner instanceof \ElggUser) {
			return null;
		}
		
		$acl = $owner->getOwnedAccessCollection('support_ticket');
		if ($acl instanceof \ElggAccessCollection) {
			return $acl;
		}
		
		// create the acl for the user
		return elgg_create_access_collection('support_ticket', $owner->guid, 'support_ticket');
	}
}
