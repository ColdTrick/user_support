<?php

$q = get_input('q');
$content = '';

// search params
$params = [
	'query' => $q,
	'search_type' => 'entities',
	'type' => 'object',
	'subtype' => UserSupportHelp::SUBTYPE,
	'limit' => 5,
	'offset' => 0,
	'sort' => 'relevance',
	'order' => 'desc',
	'owner_guid' => ELGG_ENTITIES_ANY_VALUE,
	'container_guid' => ELGG_ENTITIES_ANY_VALUE,
	'pagination' => false,
	'full_view' => false,
	'view_type_toggle' => false,
];

// search in help
$result = elgg_trigger_plugin_hook('search', 'object:' . UserSupportHelp::SUBTYPE, $params, []);
if (empty($result)) {
	$result = elgg_trigger_plugin_hook('search', 'object', $params, []);
}

$help_entities = elgg_extract('entities', $result);
if (!empty($help_entities)) {
	$content .= elgg_view_entity_list($help_entities, $params);
}

// Search in FAQ
$params['subtype'] = UserSupportFAQ::SUBTYPE;

$result = elgg_trigger_plugin_hook('search', 'object:' . UserSupportFAQ::SUBTYPE, $params, []);
if (empty($result)) {
	$result = elgg_trigger_plugin_hook('search', 'object', $params, []);
}

$faq_entities = elgg_extract('entities', $result);
if (!empty($faq_entities)) {
	$content .= elgg_view_entity_list($faq_entities, $params);
}

// show result
if (empty($help_entities) && empty($faq_entities)) {
	$content = elgg_echo('notfound');
}

echo elgg_view_module('info', elgg_echo('search:results', ['\'' . $q . '\'']), $content, ['class' => 'mts']);
