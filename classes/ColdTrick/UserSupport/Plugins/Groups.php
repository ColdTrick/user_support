<?php

namespace ColdTrick\UserSupport\Plugins;

use Elgg\Groups\Tool;

class Groups {
	
	/**
	 * Registers group tool options
	 *
	 * @param \Elgg\Hook $hook 'tool_options', 'group'
	 *
	 * @return void|false
	 */
	public static function registerToolOption(\Elgg\Hook $hook) {
		
		$group_faq = elgg_get_plugin_setting('group_faq', 'user_support');
		if ($group_faq === 'no') {
			return;
		}

		$result = $hook->getValue();
		
		$result[] = new Tool('faq', [
			'label' => elgg_echo('user_support:group:tool_option'),
			'default_on' => $group_faq === 'yes',
		]);
		
		return $result;
	}
}

