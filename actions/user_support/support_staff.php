<?php

$user_guid = (int) get_input('guid');
if (empty($user_guid)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$user = get_user($user_guid);
if (!$user instanceof \ElggUser) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

if (!empty($user->support_staff)) {
	// remove staff
	unset($user->support_staff);
	
	return elgg_ok_response('', elgg_echo('user_support:action:support_staff:removed'));
}

// add staff
$user->support_staff = time();

return elgg_ok_response('', elgg_echo('user_support:action:support_staff:added'));
