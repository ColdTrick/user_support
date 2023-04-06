<?php

namespace ColdTrick\UserSupport\Plugins;

use Elgg\Collections\Collection;
use Elgg\Groups\Tool;

/**
 * Support for the Groups plugin
 */
class Groups {
	
	/**
	 * Registers group tool options
	 *
	 * @param \Elgg\Event $event 'tool_options', 'group'
	 *
	 * @return null|Collection
	 */
	public static function registerToolOption(\Elgg\Event $event): ?Collection {
		$group_faq = elgg_get_plugin_setting('group_faq', 'user_support');
		if ($group_faq === 'no') {
			return null;
		}
		
		/* @var $result Collection */
		$result = $event->getValue();
		
		$result[] = new Tool('faq', [
			'label' => elgg_echo('user_support:group:tool_option'),
			'default_on' => $group_faq === 'yes',
		]);
		
		return $result;
	}
}
