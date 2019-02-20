<?php

// staff only action
user_support_staff_gatekeeper();

$guid = (int) get_input('guid');
if (empty($guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$entity = get_entity($guid);
if (!$entity instanceof UserSupportTicket || !$entity->canDelete()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$owner = $entity->getOwnerEntity();

if (!$entity->delete()) {
	return elgg_error_response(elgg_echo('user_support:action:ticket:delete:error:delete'));
}

return elgg_ok_response('', elgg_echo('user_support:action:ticket:delete:success'), "user_support/support_ticket/owner/{$owner->username}");
