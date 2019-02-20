<?php

elgg_make_sticky_form('user_support_faq');

$guid = (int) get_input('guid', 0);
$container_guid = (int) get_input('container_guid', 0);

$title = get_input('title');
$desc = get_input('description');
$access_id = (int) get_input('access_id', ACCESS_PRIVATE);
$tags = string_to_tag_array(get_input('tags'));
$comments = get_input('allow_comments');
$help_context = get_input('help_context');

if (empty($title) || empty($desc)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (!empty($guid)) {
	$entity = get_entity($guid);
	if (!$entity instanceof UserSupportFAQ || !$entity->canEdit()) {
		return elgg_error_response(elgg_echo('actionunauthorized'));
	}
} else {
	$container = get_entity($container_guid);
	
	$entity = new UserSupportFAQ();
	$entity->container_guid = $container_guid;
	
	if ($container instanceof ElggGroup) {
		$entity->owner_guid = elgg_get_logged_in_user_guid();
	}
	
	if (!$entity->save()) {
		return elgg_error_response(elgg_echo('save:fail'));
	}
}

if (empty($entity)) {
	return elgg_error_response(elgg_echo('save:fail'));
}

$entity->title = $title;
$entity->description = $desc;
$entity->access_id = $access_id;

$entity->tags = $tags;
$entity->allow_comments = $comments;

if (elgg_is_admin_logged_in()) {
	$entity->help_context = $help_context;
}

if (!$entity->save()) {
	return elgg_error_response(elgg_echo('user_support:action:faq:edit:error:save'));
}

elgg_clear_sticky_form('user_support_faq');

return elgg_ok_response('', elgg_echo('user_support:action:faq:edit:success'), $entity->getURL());
