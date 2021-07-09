<?php
/**
 * Group FAQ module
 */

echo elgg_view('groups/profile/module', [
	'title' => elgg_echo('user_support:menu:faq:group'),

	'entity_type' => 'object',
	'entity_subtype' => UserSupportFAQ::SUBTYPE,
]);
