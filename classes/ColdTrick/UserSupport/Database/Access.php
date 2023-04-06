<?php

namespace ColdTrick\UserSupport\Database;

/**
 * Change the database access query
 */
class Access {
	
	/**
	 * Make sure support staff can access support tickets
	 *
	 * @param \Elgg\Event $event 'get_sql', 'access'
	 *
	 * @return null|array
	 */
	public static function addSupportStaffACL(\Elgg\Event $event): ?array {
		$user_guid = (int) $event->getParam('user_guid');
		$ignore_access = (bool) $event->getParam('ignore_access');
		if (empty($user_guid) || $ignore_access) {
			return null;
		}
		
		$is_staff = elgg_call(ELGG_IGNORE_ACCESS, function() use ($user_guid) {
			return user_support_is_support_staff($user_guid);
		});
		if (!$is_staff) {
			return null;
		}
		
		$access_wheres = $event->getValue();
		
		/* @var $qb \Elgg\Database\QueryBuilder */
		$qb = $event->getParam('query_builder');
		$access_column = $event->getParam('access_column');
		$table_alias = $event->getParam('table_alias');
		$table_alias = $table_alias ? "{$table_alias}." : '';
		
		$sub = $qb->subquery('access_collections');
		$sub->select('id')
			->where($qb->compare('name', '=', 'support_ticket', ELGG_VALUE_STRING))
			->andWhere($qb->compare('subtype', '=', 'support_ticket', ELGG_VALUE_STRING));
		
		$access_wheres['ors']['support_staff'] = $qb->compare("{$table_alias}{$access_column}", 'in', $sub->getSQL());
		
		return $access_wheres;
	}
}
