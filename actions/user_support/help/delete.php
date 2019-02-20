<?php

$guid = (int) get_input('guid', 0);
if (empty($guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$entity = get_entity($guid);
if (!$entity instanceof UserSupportHelp || !$entity->canDelete()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

if (!$entity->delete()) {
	return elgg_error_response(elgg_echo('user_support:action:help:delete:error:delete'));
}

return elgg_ok_response('', elgg_echo('user_support:action:help:delete:success'));
