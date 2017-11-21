<?php

// staff only action
user_support_staff_gatekeeper();

$guid = (int) get_input('guid');

$user = elgg_get_logged_in_user_entity();

if (empty($guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$entity = get_entity($guid);
if (!$entity instanceof UserSupportTicket || !$entity->canDelete()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

if (!$entity->setStatus(UserSupportTicket::OPEN)) {
	return elgg_error_response(elgg_echo('user_support:action:ticket:reopen:error:enable'));
}

// add reopen comment
$comment = new ElggComment();
$comment->owner_guid = $user->guid;
$comment->container_guid = $entity->guid;
$comment->access_id = $entity->access_id;
$comment->description = elgg_echo('user_support:support_ticket:reopened');
$comment->save();

// notify owner
notify_user($entity->owner_guid,
	$user->guid,
	elgg_echo('generic_comment:email:subject'),
	elgg_echo('generic_comment:email:body', [
		$entity->getDisplayName(),
		$user->getDisplayName(),
		elgg_echo('user_support:support_ticket:closed'),
		$entity->getURL(),
		$user->getDisplayName(),
		$user->getURL(),
	]),
	[
		'action' => 'create',
		'object' => $comment,
	]
);

return elgg_ok_response('', elgg_echo('user_support:action:ticket:reopen:success'));
