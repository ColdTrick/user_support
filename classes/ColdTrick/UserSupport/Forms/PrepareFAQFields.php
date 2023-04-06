<?php

namespace ColdTrick\UserSupport\Forms;

/**
 * Prepare fields for the user_support/faq/edit form
 */
class PrepareFAQFields {
	
	/**
	 * Prepare the fields
	 *
	 * @param \Elgg\Event $event 'form:prepare:fields', 'user_support/faq/edit'
	 *
	 * @return array
	 */
	public function __invoke(\Elgg\Event $event): array {
		$vars = $event->getValue();
		
		$values = [
			'title' => '',
			'description' => '',
			'tags' => [],
			'help_context' => user_support_get_help_context(elgg_extract('url', $vars, '')),
			'access_id' => elgg_get_default_access(null, [
				'entity_type' => 'object',
				'entity_subtype' => \UserSupportFAQ::SUBTYPE,
				'container_guid' => elgg_extract('container_guid', $vars, elgg_get_page_owner_guid()),
			]),
			'allow_comments' => 'no',
			'container_guid' => elgg_extract('container_guid', $vars, elgg_get_page_owner_guid()),
		];
		
		// check for comment promotion
		$comment_guid = (int) elgg_extract('comment_guid', $vars);
		if (!empty($comment_guid)) {
			$comment = get_entity($comment_guid);
			if ($comment instanceof \ElggComment) {
				$support = $comment->getContainerEntity();
				if ($support instanceof \UserSupportTicket) {
					$values['title'] = $support->getDisplayName();
					$values['description'] = $comment->description;
					$values['tags'] = $support->tags;
					$values['help_context'] = $support->help_context;
					
					$values['comment'] = $comment;
				}
			}
		}
		
		// edit
		$entity = elgg_extract('entity', $vars);
		if ($entity instanceof \UserSupportFAQ) {
			foreach ($values as $key => $value) {
				$values[$key] = $entity->$key;
			}
		}
		
		return array_merge($values, $vars);
	}
}
