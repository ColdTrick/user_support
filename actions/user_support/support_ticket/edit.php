<?php

elgg_make_sticky_form('user_support_ticket');

$guid = (int) get_input('guid');

$description = get_input('description');
$help_url = get_input('help_url');
$help_context = get_input('help_context');
$tags = elgg_string_to_array((string) get_input('tags', ''));
$support_type = get_input('support_type');

if (empty($description) || empty($support_type)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (!empty($guid)) {
	$entity = get_entity($guid);
	if (!$entity instanceof UserSupportTicket || !$entity->canEdit()) {
		return elgg_error_response(elgg_echo('actionunauthorized'));
	}
} else {
	$entity = new UserSupportTicket();
	if (!$entity->save()) {
		return elgg_error_response(elgg_echo('save:fail'));
	}
}

if (empty($entity)) {
	return elgg_error_response(elgg_echo('save:fail'));
}

// make a cleaner title
$title = strip_tags($description);
$title = preg_replace('/(&nbsp;)+/', ' ', $title);
$title = trim($title);
$title = elgg_get_excerpt($title, 50);

$entity->title = $title;
$entity->description = $description;

$entity->help_url = $help_url;
$entity->help_context = $help_context;
$entity->tags = $tags;
$entity->support_type = $support_type;

if (!$entity->save()) {
	return elgg_error_response(elgg_echo('user_support:action:ticket:edit:error:save'));
}

if (empty($guid)) {
	// a new ticket was created, so notify user
	$subject = elgg_echo("user_support:support_type:{$entity->getSupportType()}") . ': ' . $entity->getDisplayName();;
	$message = elgg_echo("user_support:notify:user:create:message", [$entity->getURL(), elgg_generate_url('collection:object:support_ticket:owner', ['username' => $entity->getOwnerEntity()->username])]);
	
	$params = [
		'action' => 'create',
		'object' => $entity,
	];
	
	notify_user($entity->owner_guid, elgg_get_site_entity()->guid, $subject, $message, $params, ['email']);
}

elgg_clear_sticky_form('user_support_ticket');

return elgg_ok_response('', elgg_echo('user_support:action:ticket:edit:success'), $entity->getURL());
