<?php

namespace ColdTrick\UserSupport\Database;

class Access {
	
	/**
	 * Make sure support staff can access support tickets
	 *
	 * @param \Elgg\Hook $hook 'get_sql', 'access'
	 *
	 * @return null|array
	 */
	public static function addSupportStaffACL(\Elgg\Hook $hook): ?array {
		
		$user_guid = (int) $hook->getParam('user_guid');
		$ignore_access = (bool) $hook->getParam('ignore_access');
		if (empty($user_guid) || $ignore_access) {
			return null;
		}
		
		$is_staff = elgg_call(ELGG_IGNORE_ACCESS, function() use ($user_guid) {
			return user_support_staff_gatekeeper(false, $user_guid);
		});
		if (!$is_staff) {
			return null;
		}
		
		$access_wheres = $hook->getValue();
		
		/* @var $qb \Elgg\Database\QueryBuilder */
		$qb = $hook->getParam('query_builder');
		$access_column = $hook->getParam('access_column');
		$table_alias = $hook->getParam('table_alias');
		
		$plugin = elgg_get_plugin_from_id('user_support');
		
		$sub = $qb->subquery('access_collections');
		$sub->select('id')
			->where($qb->compare('name', 'like', 'support_ticket_acl_%', ELGG_VALUE_STRING))
			->andWhere($qb->compare('owner_guid', '=', $plugin->guid, ELGG_VALUE_GUID))
			->andWhere($qb->compare('subtype', '=', 'support_ticket', ELGG_VALUE_STRING));
		
		$access_wheres['ors']['support_staff'] = $qb->compare("{$table_alias}.{$access_column}", 'in', $sub->getSQL());
		
		return $access_wheres;
	}
}
