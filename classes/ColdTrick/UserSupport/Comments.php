<?php

namespace ColdTrick\UserSupport;

class Comments {
	
	/**
	 * Listen to the creation of a comment, to check if a SupportTicket should be closed
	 *
	 * @param string       $event  the name of the event
	 * @param string       $type   the type of the event
	 * @param \ElggComment $object supplied comment
	 *
	 * @return void
	 */
	public static function supportTicketStatus($event, $type, $object) {
		
		// is it a comment
		if (!$object instanceof \ElggComment) {
			return;
		}
		
		// on a support ticket
		$entity = $object->getContainerEntity();
		if (!$entity instanceof \UserSupportTicket) {
			return;
		}
		
		$comment_close = get_input('support_ticket_comment_close');
		
		if (!empty($comment_close)) {
			// comment and close the ticket
			$entity->setStatus(\UserSupportTicket::CLOSED);
		} elseif ($entity->owner_guid === $object->owner_guid) {
			// if the ticket owner comments, re-open the ticket
			$entity->setStatus(\UserSupportTicket::OPEN);
		}
		
		$entity->save();
	}
}
