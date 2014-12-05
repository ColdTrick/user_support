<?php
/**
 * All event handlers are bundled here
 */

/**
 * Listen to the creation of a comment
 *
 * @param string     $event  the name of the event
 * @param string     $type   the type of the event
 * @param ElggObject $object the supplied ElggObject
 *
 * @return void
 */
function user_support_create_comment_event($event, $type, $object) {
	
	// is it a comment
	if (empty($object) || !elgg_instanceof($object, "object", "comment")) {
		return;
	}
	
	// on a support ticket
	$entity = $object->getContainerEntity();
	if (empty($entity) || !elgg_instanceof($entity, "object", UserSupportTicket::SUBTYPE)) {
		return;
	}
	
	$comment_close = get_input("support_ticket_comment_close");
	
	if (!empty($comment_close)) {
		// comment and close the ticket
		$entity->setStatus(UserSupportTicket::CLOSED);
		
		$entity->save();
	} elseif ($entity->getOwnerGUID() == $object->getOwnerGUID()) {
		// if the ticket owner comments, re-open the ticket
		$entity->setStatus(UserSupportTicket::OPEN);
		
		$entity->save();
	}
}
