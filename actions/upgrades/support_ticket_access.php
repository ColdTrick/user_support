<?php
/**
 * Change the access_id of support tickets
 */

$success_count = 0;
$error_count = 0;

if (get_input('upgrade_completed')) {
	// set the upgrade as completed
	$factory = new \ElggUpgrade();
	$upgrade = $factory->getUpgradeFromPath('admin/upgrades/user_support/support_ticket_access');
	if ($upgrade instanceof \ElggUpgrade) {
		$upgrade->setCompleted();
	}
	return true;
}

$access_status = access_show_hidden_entities(true);

$batch = new \ElggBatch('elgg_get_entities', [
	'type' => 'object',
	'subtype' => UserSupportTicket::SUBTYPE,
	'limit' => 50,
	'offset' => (int) get_input('offset', 0),
	'wheres' => [
		'e.access_id = ' . ACCESS_PRIVATE,
	],
]);

$batch->setIncrementOffset(false);

/* @var $ticket UserSupportTicket */
foreach ($batch as $ticket) {
	
	$acl = user_support_get_support_ticket_acl($ticket->owner_guid);
	if (empty($acl)) {
		$error_count++;
		continue;
	}
	
	$ticket->access_id = $acl;
	if ($ticket->save()) {
		$success_count++;
	} else {
		$error_count++;
	}
}

access_show_hidden_entities($access_status);

// Give some feedback for the UI
echo json_encode([
	'numSuccess' => $success_count,
	'numErrors' => $error_count,
]);
