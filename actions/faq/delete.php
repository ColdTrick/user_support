<?php

$guid = (int) get_input('guid', 0);
if (empty($guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$entity = get_entity($guid);
if (!$entity instanceof UserSupportFAQ || !$entity->canDelete()) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$container = $entity->getContainerEntity();
$forward_url = 'user_support/faq';
if ($container instanceof ElggGroup) {
	$forward_url .= "/group/{$container->guid}/all";
}

if (!$entity->delete()) {
	return elgg_error_response(elgg_echo('user_support:action:faq:delete:error:delete'));
}

return elgg_ok_response('', elgg_echo('user_support:action:faq:delete:success'), $forward_url);
