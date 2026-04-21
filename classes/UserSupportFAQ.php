<?php

/**
 * The helper class for FAQ objects
 *
 * @property string $allow_comments allow comments on this FAQ (yes|no)
 * @property string $help_context   help context to show the FAQ on
 */
class UserSupportFAQ extends \ElggObject {
	
	public const SUBTYPE = 'faq';
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['owner_guid'] = $site->guid;
		$this->attributes['container_guid'] = $site->guid;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function canComment(int $user_guid = 0): bool {
		if ($this->allow_comments !== 'yes') {
			return false;
		}
		
		return parent::canComment($user_guid);
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function getDefaultFields(): array {
		$fields = [];
		
		$fields[] = [
			'#type' => 'text',
			'#label' => elgg_echo('user_support:question'),
			'name' => 'title',
			'required' => true,
		];
		
		$fields[] = [
			'#type' => 'longtext',
			'#label' => elgg_echo('user_support:answer'),
			'name' => 'description',
			'required' => true,
		];
		
		$fields[] = [
			'#type' => 'tags',
			'#label' => elgg_echo('tags'),
			'name' => 'tags',
		];
		
		if (elgg_is_admin_logged_in()) {
			/** @var \ElggBatch $metadata */
			$metadata = elgg_get_metadata([
				'metadata_name' => 'help_context',
				'type' => 'object',
				'subtypes' => [
					self::SUBTYPE,
					\UserSupportHelp::SUBTYPE,
					\UserSupportTicket::SUBTYPE,
				],
				'limit' => false,
				'batch' => true,
			]);
			
			// make it into an array
			$help_contexts = [];
			/** @var \ElggMetadata $md */
			foreach ($metadata as $md) {
				$help_contexts[$md->value] = true;
			}
			
			if (!empty($help_contexts)) {
				$help_contexts = array_keys($help_contexts);
				natcasesort($help_contexts);
				
				$fields[] = [
					'#type' => 'select',
					'#label' => elgg_echo('user_support:help_context'),
					'#help' => elgg_echo('user_support:help_context:help'),
					'name' => 'help_context',
					'options' => $help_contexts,
					'multiple' => true,
					'size' => min(count($help_contexts), 5),
				];
			}
		}
		
		$fields[] = [
			'#type' => 'checkbox',
			'#label' => elgg_echo('user_support:allow_comments'),
			'name' => 'allow_comments',
			'default' => 'no',
			'value' => 'yes',
			'switch' => true,
		];
		
		$fields[] = [
			'#type' => 'access',
			'#label' => elgg_echo('access'),
			'name' => 'access_id',
			'entity_type' => 'object',
			'entity_subtype' => self::SUBTYPE,
		];
		
		return $fields;
	}
}
