<?php

namespace ColdTrick\UserSupport\Controllers;

use ColdTrick\UserSupport\Database\TagFilter;
use Elgg\Controllers\GenericContentListing;
use Elgg\Database\QueryBuilder;
use Elgg\Exceptions\Http\BadRequestException;

/**
 * List FAQs
 */
class FAQListing extends GenericContentListing {
	
	/**
	 * {@inheritdoc}
	 */
	protected function getListingOptions(string $page, array $options): array {
		$options['wheres'] = [];
		$options['metadata_name_value_pairs'] = [];
		
		switch ($page) {
			case 'context':
				$help_context = $this->request->getParam('help_context');
				if (empty($help_context)) {
					throw new BadRequestException();
				}
			
				$options['metadata_name_value_pairs'][] = [
					'name' => 'help_context',
					'value' => $help_context,
				];
				break;
			case 'search':
				$faq_query = $this->request->getParam('faq_query');
				if (empty($faq_query)) {
					throw new BadRequestException();
				}
				
				$options['query'] = $faq_query;
				// continue to tag filtering
			case 'all':
				$filter = (array) $this->request->getParam('filter');
				$filter = array_values($filter); // indexing could be messed up
			
				if (!empty($filter)) {
					$options['wheres'][] = function (QueryBuilder $qb, $main_alias) use ($filter) {
						// add tag filter
						$filter = new TagFilter($filter);
						
						return $filter($qb, $main_alias);
					};
				}
				break;
		}
		
		return $options;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getPageOptions(string $page, array $options): array {
		$options = parent::getPageOptions($page, $options);
		$options['filter_id'] = 'faq';
		
		return $options;
	}
	
	/**
	 * List FAQ from a certain context
	 *
	 * @param array $options listing options
	 *
	 * @return string
	 */
	protected function listContext(array $options): string {
		elgg_push_collection_breadcrumbs($options['type'], $options['subtype']);
		
		return elgg_view_page('', $this->getPageOptions('search', [
			'title' => elgg_echo("collection:{$options['type']}:{$options['subtype']}:context"),
			'content' => elgg_view('page/list/all', [
				'options' => $options,
				'page' => 'context',
				'filter' => false,
			]),
			'filter_value' => 'context',
		]));
	}
	
	/**
	 * Search results for FAQ
	 *
	 * @param array $options listing options
	 *
	 * @return string
	 */
	protected function listSearch(array $options): string {
		elgg_push_collection_breadcrumbs($options['type'], $options['subtype']);
		
		return elgg_view_page('', $this->getPageOptions('search', [
			'title' => elgg_echo("collection:{$options['type']}:{$options['subtype']}:search", [$options['query']]),
			'content' => elgg_view('page/list/all', [
				'options' => $options,
				'page' => 'search',
				'getter' => 'elgg_search',
			]),
			'filter_value' => 'search',
		]));
	}
}
