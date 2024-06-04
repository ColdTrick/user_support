<?php

elgg_import_esm('forms/user_support/help_center/search');

echo elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#type' => 'search',
			'name' => 'q',
			'placeholder' => elgg_echo('user_support:help_center:search'),
			'class' => 'user-support-help-center-search-input',
		],
		[
			'#type' => 'reset',
			'text' => elgg_echo('reset'),
			'class' => [
				'elgg-button-cancel',
				'hidden',
			],
		],
		[
			'#type' => 'submit',
			'text' => elgg_echo('search'),
			'class' => 'hidden',
		],
	],
]);
