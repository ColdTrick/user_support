<?php

namespace ColdTrick\UserSupport\Seeder;

use Elgg\Database\Seeds\Seed;
use Elgg\Exceptions\Seeding\MaxAttemptsException;

/**
 * Seed Helps
 */
class Helps extends Seed {
	
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
				
				/* @var $entity \UserSupportHelp */
				$entity = $this->createObject([
					'subtype' => \UserSupportHelp::SUBTYPE,
					'owner_guid' => $site->guid,
					'container_guid' => $site->guid,
					'help_context' => $this->getHelpContext(),
				]);
				
				$logger->enable();
			} catch (MaxAttemptsException $e) {
				// unable to create help with the giver options
				$logger->enable();
				continue;
			}
			
			// undo some seeded data
			unset($entity->title);
		}
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function unseed() {
		/* @var $entities \ElggBatch */
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtype' => \UserSupportHelp::SUBTYPE,
			'metadata_name' => '__faker',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);
		
		/* @var $entity \UserSupportHelp */
		foreach ($entities as $entity) {
			if ($entity->delete()) {
				$this->log("Deleted Help {$entity->guid}");
			} else {
				$this->log("Failed to delete Help {$entity->guid}");
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
		return \UserSupportHelp::SUBTYPE;
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function getCountOptions(): array {
		return [
			'type' => 'object',
			'subtype' => \UserSupportHelp::SUBTYPE,
		];
	}
}