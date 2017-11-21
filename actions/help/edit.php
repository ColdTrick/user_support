<?php
	
$guid = (int) get_input('guid');
$desc = get_input('description');
$help_context = get_input('help_context');
$tags = string_to_tag_array(get_input('tags'));

if (empty($desc) || empty($help_context)) {
	return elgg_error_response(elgg_echo('user_support:action:help:edit:error:input'));
}

if (!empty($guid)) {
	$entity = get_entity($guid);
	
	if (!$entity instanceof UserSupportHelp || !$entity->canEdit()) {
		return elgg_error_response(elgg_echo('actionunauthorized'));
	}
} else {
	$entity = new UserSupportHelp();
	
	if (!$entity->save()) {
		return elgg_error_response(elgg_echo('save:fail'));
	}
}

if (empty($entity)) {
	return elgg_error_response(elgg_echo('save:fail'));
}

$help->description = $desc;
$help->tags = $tags;
$help->help_context = $help_context;

if (!$help->save()) {
	return elgg_error_response(elgg_echo('user_support:action:help:edit:error:save'));
}

return elgg_ok_response('', elgg_echo('user_support:action:help:edit:success'));
