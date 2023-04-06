<?php

namespace ColdTrick\UserSupport\Upgrades;

use Elgg\Database\Select;
use Elgg\Upgrade\Result;

class MigrateACLOwnership extends \Elgg\Upgrade\AsynchronousUpgrade {
	
	/**
	 * {@inheritdoc}
	 */
	public function getVersion(): int {
		return 2023040601;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function shouldBeSkipped(): bool {
		return empty($this->countItems());
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function needsIncrementOffset(): bool {
		return false;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function countItems(): int {
		$plugin = elgg_get_plugin_from_id('user_support');
		
		$select = Select::fromTable('access_collections');
		$select->select('count(*) AS total')
			->where($select->compare('owner_guid', '=', $plugin->guid, ELGG_VALUE_GUID))
			->andWhere($select->compare('subtype', '=', 'support_ticket', ELGG_VALUE_STRING));
		
		$result = elgg()->db->getDataRow($select);
		if (empty($result)) {
			return 0;
		}
		
		return (int) $result->total;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function run(Result $result, $offset): Result {
		$plugin = elgg_get_plugin_from_id('user_support');
		
		$select = Select::fromTable('access_collections');
		$select->select('*')
			->where($select->compare('owner_guid', '=', $plugin->guid, ELGG_VALUE_GUID))
			->andWhere($select->compare('subtype', '=', 'support_ticket', ELGG_VALUE_STRING))
			->setMaxResults(50)
			->setFirstResult($offset);
		
		$acls = elgg()->db->getData($select, [_elgg_services()->accessCollections, 'rowToElggAccessCollection']);
		/* @var $acl \ElggAccessCollection */
		foreach ($acls as $acl) {
			// name: support_ticket_acl_{$user_guid}
			$user_guid = (int) substr($acl->name, strlen('support_ticket_acl_'));
			
			$user = elgg_call(ELGG_SHOW_DISABLED_ENTITIES, function() use ($user_guid) {
				return get_user($user_guid);
			});
			if (!$user instanceof \ElggUser) {
				// not a user, so remove
				if (!$acl->delete()) {
					$result->addFailures();
				} else {
					$result->addSuccesses();
				}
				
				continue;
			}
			
			// rename
			$acl->name = 'support_ticket';
			
			// change owner to the user
			$acl->owner_guid = $user_guid;
			if (!$acl->save()) {
				$result->addFailures();
				continue;
			}
			
			// remove plugin setting for the user
			$user->removePluginSetting('user_support', 'support_ticket_acl');
			
			$result->addSuccesses();
		}
		
		return $result;
	}
}