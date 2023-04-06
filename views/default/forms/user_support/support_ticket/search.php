<?php

echo elgg_view_field([
	'#type' => 'search',
	'name' => 'q',
	'value' => get_input('q'),
	'placeholder' => elgg_echo('search'),
]);
