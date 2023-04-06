<?php

namespace ColdTrick\UserSupport\Database;

use Elgg\Database\QueryBuilder;

/**
 * Tag related database query
 */
class TagFilter {
	
	/**
	 * @var string[]
	 */
	protected array $filter;
	
	/**
	 * Create a tag filter
	 *
	 * @param string[] $filter tags to filter on
	 */
	public function __construct(array $filter) {
		$this->filter = array_values($filter); // this way we always have correct integer keys
	}
	
	/**
	 * Build the query parts
	 *
	 * @param QueryBuilder $qb         Database query builder
	 * @param string       $main_alias Main database table alias
	 *
	 * @return \Doctrine\DBAL\Query\Expression\CompositeExpression|string
	 */
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
