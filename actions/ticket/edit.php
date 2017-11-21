<?php

$guid = (int) get_input('guid');

$title = get_input('title');
$help_url = get_input('help_url');
$help_context = get_input('help_context');
$tags = string_to_tag_array(get_input('tags'));
$support_type = get_input('support_type');

$loggedin_user = elgg_get_logged_in_user_entity();

if (empty($title) || empty($support_type)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (!empty($guid)) {
	$entity = get_entity($guid);
	if (!$entity instanceof UserSupportTicket || !$entity->canEdit()) {
		return elgg_error_response(elgg_echo('actionunauthorized'));
	}
} else {
	$entity = new UserSupportTicket();
	
	$entity->title = elgg_get_excerpt($title, 50);
	$entity->description = $title;
	
	if (!$entity->save()) {
		return elgg_error_response(elgg_echo('save:fail'));
	}
}

if (empty($entity)) {
	return elgg_error_response(elgg_echo('save:fail'));
}

$entity->title = elgg_get_excerpt($title, 50);
$entity->description = $title;

$entity->help_url = $help_url;
$entity->help_context = $help_context;
$entity->tags = $tags;
$entity->support_type = $support_type;

if (!$entity->save()) {
	return elgg_error_response(elgg_echo('user_support:action:ticket:edit:error:save'));
}

return elgg_ok_response('', elgg_echo('user_support:action:ticket:edit:success'), $entity->getURL());
