<?php

namespace ColdTrick\UserSupport\Upgrades;

use Elgg\Database\Select;
use Elgg\Database\Update;
use Elgg\Upgrade\AsynchronousUpgrade;
use Elgg\Upgrade\Result;

class SetSupportTicketACLSubtype implements AsynchronousUpgrade {
	
	/**
	 * {@inheritDoc}
	 */
	public function getVersion(): int {
		return 2022071901;
	}

	/**
	 * {@inheritDoc}
	 */
	public function needsIncrementOffset(): bool {
		return false;
	}

	/**
	 * {@inheritDoc}
	 */
	public function shouldBeSkipped(): bool {
		return empty($this->countItems());
	}

	/**
	 * {@inheritDoc}
	 */
	public function countItems(): int {
		$plugin = elgg_get_plugin_from_id('user_support');
		
		$select = Select::fromTable('access_collections');
		$select->select('count(*) as total')
			->andWhere($select->compare('name', 'like', 'support_ticket_acl_%', ELGG_VALUE_STRING))
			->andWhere($select->compare('owner_guid', '=', $plugin->guid, ELGG_VALUE_GUID))
			->andWhere($select->compare('subtype', 'is null'));
		
		$result = elgg()->db->getDataRow($select);
		
		return (int) $result->total;
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(Result $result, $offset): Result {
		$plugin = elgg_get_plugin_from_id('user_support');
		
		$update = Update::table('access_collections');
		$update->set('subtype', $update->param('support_ticket', ELGG_VALUE_STRING))
			->andWhere($update->compare('name', 'like', 'support_ticket_acl_%', ELGG_VALUE_STRING))
			->andWhere($update->compare('owner_guid', '=', $plugin->guid, ELGG_VALUE_GUID))
			->andWhere($update->compare('subtype', 'is null'));
		
		$row_count = elgg()->db->updateData($update, true);
		
		$result->addSuccesses($row_count);
		$result->markComplete();
		
		return $result;
	}
}
