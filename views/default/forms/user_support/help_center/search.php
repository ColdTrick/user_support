<?php

elgg_require_js('user_support/help_center/search');

echo elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#type' => 'text',
			'name' => 'q',
			'placeholder' => elgg_echo('user_support:help_center:search'),
			'class' => 'user-support-help-center-search-input',
		],
		[
			'#type' => 'reset',
			'value' => elgg_echo('reset'),
			'class' => [
				'elgg-button-cancel',
				'hidden',
			],
		],
		[
			'#type' => 'submit',
			'value' => elgg_echo('search'),
			'class' => 'hidden',
		],
	],
]);
