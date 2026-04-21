<?php

/**
 * Helper class for Help objects
 *
 * @property string $help_context help context to show the help on
 */
class UserSupportHelp extends \ElggObject {
	
	public const SUBTYPE = 'help';
	
	/**
	 * {@inheritdoc}
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();
		
		$site = elgg_get_site_entity();
		
		$this->attributes['subtype'] = self::SUBTYPE;
		$this->attributes['access_id'] = ACCESS_PUBLIC;
		$this->attributes['owner_guid'] = $site->guid;
		$this->attributes['container_guid'] = $site->guid;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function getDefaultFields(): array {
		$fields = [];
		
		$fields[] = [
			'#type' => 'hidden',
			'name' => 'help_context',
		];
		
		$fields[] = [
			'#type' => 'longtext',
			'#label' => elgg_echo('description'),
			'name' => 'description',
			'required' => true,
		];
		
		$fields[] = [
			'#type' => 'tags',
			'#label' => elgg_echo('tags'),
			'name' => 'tags',
		];
		
		return $fields;
	}
}
