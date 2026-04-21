<?php

namespace ColdTrick\UserSupport\Controllers;

use Elgg\Controllers\GenericContentListing;
use Elgg\Exceptions\Http\BadRequestException;
use Elgg\Exceptions\Http\EntityPermissionsException;

/**
 * List support tickets
 */
class SupportTicketListing extends GenericContentListing {
	
	/**
	 * {@inheritdoc}
	 */
	protected function getListingOptions(string $page, array $options): array {
		$options['sort_by'] = [
			'property' => 'time_updated',
			'direction' => 'DESC',
		];
		$options['metadata_name_value_pairs'] = [];
		
		switch ($page) {
			case 'all':
			case 'owner':
				$options['metadata_name_value_pairs'][] = [
					'name' => 'status',
					'value' => \UserSupportTicket::OPEN,
				];
				break;
			case 'archive':
			case 'owner_archive':
				$options['metadata_name_value_pairs'][] = [
					'name' => 'status',
					'value' => \UserSupportTicket::CLOSED,
				];
				break;
			case 'support_staff':
				unset($options['sort_by']);
				$options['metadata_names'] = [
					'support_staff',
				];
				$options['no_results'] = elgg_echo('user_support:tickets:staff:no_results');
				
				break;
		}
		
		$query = $this->request->getParam('q');
		if (!empty($query)) {
			$options['query'] = $query;
		}
		
		return $options;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getPageOptions(string $page, array $options): array {
		$options = parent::getPageOptions($page, $options);
		$options['filter_id'] = 'support_ticket';
		
		return $options;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function listOwner(array $options): string {
		if (!$this->page_owner?->canEdit() && !user_support_is_support_staff()) {
			throw new EntityPermissionsException();
		}
		
		return parent::listOwner($options);
	}
	
	/**
	 * List all closed support tickets
	 *
	 * @param array $options listing options
	 *
	 * @return string
	 */
	protected function listArchive(array $options): string {
		elgg_push_collection_breadcrumbs($options['type'], $options['subtype']);
		
		return elgg_view_page('', $this->getPageOptions('archive', [
			'title' => elgg_echo("collection:{$options['type']}:{$options['subtype']}:archive"),
			'content' => elgg_view('page/list/all', [
				'options' => $options,
				'page' => 'archive',
			]),
			'filter_value' => 'archive',
		]));
	}
	
	/**
	 * List closed support tickets of an owner
	 *
	 * @param array $options listing options
	 *
	 * @return string
	 * @throws BadRequestException
	 * @throws EntityPermissionsException
	 */
	protected function listOwnerArchive(array $options): string {
		if (!$this->page_owner instanceof \ElggUser) {
			throw new BadRequestException();
		}
		
		if (!$this->page_owner->canEdit() && !user_support_is_support_staff()) {
			throw new EntityPermissionsException();
		}
		
		elgg_push_collection_breadcrumbs($options['type'], $options['subtype'], $this->page_owner);
		
		$owner_options = [
			'owner_guid' => $this->page_owner->guid,
			'preload_owners' => false,
		];
		
		return elgg_view_page('', $this->getPageOptions('owner_archive', [
			'title' => elgg_echo("collection:{$options['type']}:{$options['subtype']}:owner_archive", [$this->page_owner->getDisplayName()]),
			'content' => elgg_view('page/list/all', [
				'entity' => $this->page_owner,
				'options' => array_merge($options, $owner_options),
				'page' => 'owner_archive',
			]),
			'filter_value' => $this->page_owner->guid === elgg_get_logged_in_user_guid() ? 'owner_archive' : 'none',
		]));
	}
	
	/**
	 * List support staff
	 *
	 * @param array $options listing options
	 *
	 * @return string
	 */
	protected function listSupportStaff(array $options): string {
		elgg_push_collection_breadcrumbs('object', \UserSupportTicket::SUBTYPE);
		
		return elgg_view_page('', $this->getPageOptions('support_staff', [
			'title' => elgg_echo("collection:{$options['type']}:{$options['subtype']}:support_staff"),
			'content' => elgg_view('page/list/all', [
				'options' => $options,
				'page' => 'support_staff',
			]),
			'filter_value' => 'support_staff',
		]));
	}
}
