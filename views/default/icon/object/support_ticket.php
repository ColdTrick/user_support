<?php


$entity = elgg_extract('entity', $vars);
if (!($entity instanceof UserSupportTicket)) {
	return;
}

$icon_names = [
	'bug' => 'bug',
	'request' => 'lightbulb-o',
	'question' => 'question-circle',
];

$icon_name = elgg_extract($entity->getSupportType(), $icon_names, 'question-circle');

unset($vars['size']);

echo elgg_view_icon($icon_name, $vars);
