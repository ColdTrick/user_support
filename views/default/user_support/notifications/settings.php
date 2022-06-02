<?php
/**
 * Add a notification setting for admins/support staff on the notification settings page
 *
 * @uses $vars['entity'] the user for which to set the settings
 */

$user = elgg_extract('entity', $vars);
if (!$user instanceof \ElggUser) {
	return;
}

// allowed for Admins and support staff
if (!user_support_staff_gatekeeper(false, $user->guid)) {
	return;
}

$params = $vars;
$params['description'] = elgg_echo('user_support:notifications:support_ticket');
$params['purpose'] = 'user_support_ticket';

echo elgg_view('notifications/settings/record', $params);
