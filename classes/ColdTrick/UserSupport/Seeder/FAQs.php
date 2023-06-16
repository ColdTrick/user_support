<?php

namespace ColdTrick\UserSupport\Seeder;

use Elgg\Database\Seeds\Seed;
use Elgg\Exceptions\Seeding\MaxAttemptsException;

/**
 * Seed FAQs
 */
class FAQs extends Seed {
	
	use ContextProvider;
	
	/**
	 * {@inheritDoc}
	 */
	public function seed() {
		$this->advance($this->getCount());
		
		$logger = elgg()->logger;
		$site = elgg_get_site_entity();
		
		while ($this->getCount() < $this->limit) {
			try {
				$logger->disable();
				
				/* @var $entity \UserSupportFAQ */
				$entity = $this->createObject([
					'subtype' => \UserSupportFAQ::SUBTYPE,
					'owner_guid' => $site->guid,
					'container_guid' => $site->guid,
					'allow_comments' => $this->faker()->boolean() ? 'yes' : 'no',
					'help_context' => $this->getHelpContext(),
				]);
				
				$logger->enable();
			} catch (MaxAttemptsException $e) {
				// unable to create FAQ with the giver options
				$logger->enable();
				continue;
			}
			
			if ($entity->allow_comments === 'yes') {
				$this->createComments($entity);
			}
			
			$this->createLikes($entity);
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function unseed() {
		/* @var $entities \ElggBatch */
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtype' => \UserSupportFAQ::SUBTYPE,
			'metadata_name' => '__faker',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);
		
		/* @var $entity \UserSupportFAQ */
		foreach ($entities as $entity) {
			if ($entity->delete()) {
				$this->log("Deleted FAQ {$entity->guid}");
			} else {
				$this->log("Failed to delete FAQ {$entity->guid}");
				$entities->reportFailure();
				continue;
			}
			
			$this->advance();
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public static function getType(): string {
		return \UserSupportFAQ::SUBTYPE;
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getCountOptions(): array {
		return [
			'type' => 'object',
			'subtype' => \UserSupportFAQ::SUBTYPE,
		];
	}
}