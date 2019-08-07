<?php

namespace ColdTrick\UserSupport;

class Comments {
	
	/**
	 * Listen to the creation of a comment, to check if a SupportTicket should be closed
	 *
	 * @param \Elgg\Event $event 'create', 'object'
	 *
	 * @return void
	 */
	public static function supportTicketStatus(\Elgg\Event $event) {
		
		$object = $event->getObject();
		// is it a comment
		if (!$object instanceof \ElggComment) {
			return;
		}
		
		// on a support ticket
		$entity = $object->getContainerEntity();
		if (!$entity instanceof \UserSupportTicket) {
			return;
		}
		
		if ($object->description === elgg_echo('user_support:support_ticket:closed')) {
			// ticket was closed, using the action, do nothing
			return;
		}
		if ($object->description === elgg_echo('user_support:support_ticket:reopened')) {
			// ticket was reopend, using the action, do nothing
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
