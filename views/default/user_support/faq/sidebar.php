<?php

use Elgg\Database\QueryBuilder;
use ColdTrick\UserSupport\Database\TagFilter;

$filter = (array) get_input('filter');
$query_params = ['filter' => $filter];
$faq_query = get_input('faq_query');
$menu_items = [];
$guids = null;

if (!empty($faq_query)) {
	$query_params['faq_query'] = $faq_query;
}

if (!empty($filter) || !empty($faq_query)) {
	// get entity guids for filtering elgg_get_tags
	$guid_options = [
		'type' => 'object',
		'subtype' => \UserSupportFAQ::SUBTYPE,
		'limit' => false,
		'wheres' => [
			function (QueryBuilder $qb, $main_alias) use ($filter) {
				// add tag filter
				$filter = new TagFilter($filter);
				
				return $filter($qb, $main_alias);
			}
		],
		'callback' => function($row) {
			return (int) $row->guid;
		},
	];
	
	// text search
	$getter = 'elgg_get_entities';
	
	if (!empty($faq_query)) {
		$options['query'] = $faq_query;
		$getter = 'elgg_search';
	}
		
	$guids = $getter($guid_options);
	
	foreach ($filter as $index => $filter_tag) {
		if ($index > 2) {
			// prevent filtering on too much tags
			break;
		}
		$tag_query_params = $query_params;
		
		$pos = array_search($filter_tag, $tag_query_params['filter']);
		// selected items can be deselected
		unset($tag_query_params['filter'][$pos]);
		
		$menu_items[] = [
			'name' => $filter_tag,
			'text' => $filter_tag,
			'icon' => 'checkmark',
			'href' => elgg_generate_url('collection:object:faq:all', $tag_query_params),
		];
	}
}

if (($guids == null || (count($guids) > 1)) && (count($filter) < 3)) {
	$tag_options = [
		'type' => 'object',
		'subtype' => UserSupportFAQ::SUBTYPE,
		'tag_names' => ['tags'],
		'wheres' => [],
		'limit' => 5,
	];
	
	if (!empty($filter)) {
		$tag_options['wheres'][] = function (QueryBuilder $qb) use ($filter) {
			return $qb->compare('msv.string', 'NOT IN', $filter, ELGG_VALUE_STRING);
		};
	}
	
	if (!empty($guids)) {
		$tag_options['guids'] = $guids;
	}
	
	$tags = elgg_get_tags($tag_options);
	if (!empty($tags)) {
		foreach ($tags as $tag) {
			$tag_text = $tag->tag;
			
			$tag_query_params = $query_params;
			
			// add the extra tag to the filter
			$tag_query_params['filter'][]  = $tag_text;
			
			$menu_items[] = [
				'name' => $tag_text,
				'text' => $tag_text,
				'icon' => 'checkmark',
				'href' => elgg_generate_url('collection:object:faq:all', $tag_query_params),
			];
		}
	}
}

if (!empty($menu_items)) {
	$body = elgg_view_menu('faq_filter', [
		'items' => $menu_items,
		'class' => ['elgg-menu-page'],
	]);
	
	echo elgg_view_module('aside', elgg_echo('user_support:faq:sidebar:filter'), $body);
}
