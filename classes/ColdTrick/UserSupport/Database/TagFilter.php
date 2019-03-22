<?php

namespace ColdTrick\UserSupport\Database;

use Elgg\Database\QueryBuilder;

class TagFilter {
	
	/**
	 * @var string[]
	 */
	protected $filter;
	
	public function __construct(array $filter) {
		$this->filter = $filter;
	}
	
	public function __invoke(QueryBuilder $qb, $main_alias) {
		
		$wheres = [];
		
		foreach ($this->filter as $index => $filter) {
			// don't make the query too complex
			if ($index > 2) {
				break;
			}
			
			$tag_join_alias = $qb->joinMetadataTable($main_alias, 'guid', 'tags', 'inner', "tags_{$index}");
			
			$wheres[] = $qb->compare("{$tag_join_alias}.value", '=', $filter, ELGG_VALUE_STRING);
		}
		
		return $qb->merge($wheres);
	}
}
