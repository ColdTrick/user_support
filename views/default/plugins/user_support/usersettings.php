<?php

$page_owner = elgg_get_page_owner_entity();
if (!$page_owner instanceof ElggUser || $page_owner->guid !== elgg_get_logged_in_user_guid()) {
	return;
}

if (!user_support_staff_gatekeeper(false, $page_owner->guid)) {
	return;
}

/* @var $plugin ElggPlugin */
$plugin = elgg_extract('entity', $vars);

echo elgg_view_field([
	'#type' => 'checkbox',
	'#label' => elgg_echo('user_support:usersettings:admin_notify'),
	'name' => 'params[admin_notify]',
	'default' => 'no',
	'value' => 'yes',
	'checked' => $plugin->getUserSetting('admin_notify', $page_owner->guid) === 'yes',
	'switch' => true,
]);
