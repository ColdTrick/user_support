<?php

/* @var $widget ElggWidget */
$widget = elgg_extract("entity", $vars);

echo elgg_view('object/widget/edit/num_display', [
	'entity' => $widget,
	'default' => 4,
	'min' => 1,
	'max' => 99,
]);
