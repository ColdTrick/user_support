<?php

namespace ColdTrick\UserSupport\Seeder;

use Elgg\Database\Seeds\Seed;
use Elgg\Exceptions\Seeding\MaxAttemptsException;

/**
 * Seed support tickets
 */
class SupportTickets extends Seed {
	
	use ContextProvider;
	
	protected $support_types = ['bug', 'request', 'question'];
	
	/**
	 * {@inheritdoc}
	 */
	public function seed() {
		$this->advance($this->getCount());
		
		$logger = elgg()->logger;
		$session_manager = elgg()->session_manager;
		$logged_in = $session_manager->getLoggedInUser();
		
		while ($this->getCount() < $this->limit) {
			$owner = $this->getRandomUser();
			
			$session_manager->setLoggedInUser($owner);
			
			$route = $this->getRandomRoute();
			
			try {
				$logger->disable();
				
				/* @var $entity \UserSupportTicket */
				$entity = $this->createObject([
					'subtype' => \UserSupportTicket::SUBTYPE,
					'owner_guid' => $owner->guid,
					'access_id' => ACCESS_PRIVATE,
					'support_type' => $this->getRandomSupportType(),
					'help_url' => $this->getUrl($route),
					'help_context' => $this->getHelpContext($route),
				]);
				
				$logger->enable();
			} catch (MaxAttemptsException $e) {
				// unable to create support ticket with the giver options
				$logger->enable();
				continue;
			}
			
			$this->createComments($entity, $this->faker()->numberBetween(0, 5));
			
			if ($this->faker()->boolean(25)) {
				$entity->setStatus(\UserSupportTicket::CLOSED);
			}
			
			$this->advance();
		}
		
		if ($logged_in) {
			$session_manager->setLoggedInUser($logged_in);
		} else {
			$session_manager->removeLoggedInUser();
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function unseed() {
		/* @var $entities \ElggBatch */
		$entities = elgg_get_entities([
			'type' => 'object',
			'subtype' => \UserSupportTicket::SUBTYPE,
			'metadata_name' => '__faker',
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
		]);
		
		/* @var $entity \UserSupportTicket */
		foreach ($entities as $entity) {
			if ($entity->delete()) {
				$this->log("Deleted support ticket {$entity->guid}");
			} else {
				$this->log("Failed to delete support ticket {$entity->guid}");
				$entities->reportFailure();
				continue;
			}
			
			$this->advance();
		}
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function getType(): string {
		return \UserSupportTicket::SUBTYPE;
	}
	
	/**
	 * {@inheritdoc}
	 */
	protected function getCountOptions(): array {
		return [
			'type' => 'object',
			'subtype' => \UserSupportTicket::SUBTYPE,
		];
	}
	
	/**
	 * Get a support type
	 *
	 * @return string
	 */
	protected function getRandomSupportType(): string {
		$key = array_rand($this->support_types);
		
		return $this->support_types[$key];
	}
}
