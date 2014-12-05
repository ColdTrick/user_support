<?php
/**
 * All plugin hook handlers are bundled here
 */

/**
 * Add to the entity menu
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function user_support_entity_menu_hook($hook, $type, $return_value, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$entity = elgg_extract("entity", $params);
	
	if (empty($entity)) {
		return $return_value;
	}
	
	if (elgg_instanceof($entity, "object", UserSupportTicket::SUBTYPE, "UserSupportTicket")) {
		if (user_support_staff_gatekeeper(false)) {
			if ($entity->getStatus() == UserSupportTicket::OPEN) {
				$return_value[] = ElggMenuItem::factory(array(
					"name" => "status",
					"text" => elgg_echo("close"),
					"href" => "action/user_support/support_ticket/close?guid=" . $entity->getGUID(),
					"is_action" => true,
					"priority" => 200
				));
			} else {
				$return_value[] = ElggMenuItem::factory(array(
					"name" => "status",
					"text" => elgg_echo("user_support:reopen"),
					"href" => "action/user_support/support_ticket/reopen?guid=" . $entity->getGUID(),
					"is_action" => true,
					"priority" => 200
				));
			}
		}

		// cleanup some menu items
		foreach ($return_value as $index => $menu_item) {
			if (($menu_item->getName() == "delete") && !user_support_staff_gatekeeper(false)) {
				unset($return_value[$index]);
			} elseif (in_array($menu_item->getName(), array("likes", "likes_count"))) {
				unset($return_value[$index]);
			}
		}
	} elseif (elgg_instanceof($entity, "object", UserSupportHelp::SUBTYPE, "UserSupportHelp")) {
		// cleanup all menu items
		foreach ($return_value as $index => $menu_item) {
			if ($menu_item->getName() != "delete") {
				unset($return_value[$index]);
			}
		}
		
		if ($entity->canEdit()) {
			// user_support_help_edit_form_wrapper
			$return_value[] = ElggMenuItem::factory(array(
				"name" => "edit",
				"text" => elgg_echo("edit"),
				"href" => "#",
				"id" => "user-support-help-center-edit-help",
				"priority" => 200
			));
		}
	}
	
	return $return_value;
}

/**
 * Add to the site menu
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function user_support_site_menu_hook($hook, $type, $return_value, $params) {
	
	if (elgg_get_plugin_setting("add_faq_site_menu_item", "user_support") != "no") {
		$return_value[] = ElggMenuItem::factory(array(
			"name" => "faq",
			"text" => elgg_echo("user_support:menu:faq"),
			"href" => "user_support/faq"
		));
	}

	if (elgg_get_plugin_setting("add_help_center_site_menu_item", "user_support") == "yes") {
		$options = array(
			"name" => "help_center",
			"text" => elgg_echo("user_support:button:text"),
			"href" => "user_support/help_center"
		);
		
		if (elgg_get_plugin_setting("show_as_popup", "user_support") != "no") {
			elgg_load_js("lightbox");
			elgg_load_css("lightbox");
			$options["link_class"] = "elgg-lightbox";
		}
		
		$return_value[] = ElggMenuItem::factory($options);
	}
	
	if ($user = elgg_get_logged_in_user_entity()) {
		$return_value[] = ElggMenuItem::factory(array(
			"name" => "support_ticket_mine",
			"text" => elgg_echo("user_support:menu:support_tickets:mine"),
			"href" => "user_support/support_ticket/owner/" . $user->username
		));
	}
	
	return $return_value;
}

/**
 * Add to the footer menu
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function user_support_footer_menu_hook($hook, $type, $return_value, $params) {
	
	if (elgg_get_plugin_setting("add_faq_footer_menu_item", "user_support") == "yes") {
		$return_value[] = ElggMenuItem::factory(array(
			"name" => "faq",
			"text" => elgg_echo("user_support:menu:faq"),
			"href" => "user_support/faq"
		));
	}
	
	return $return_value;
}

/**
 * Add to the page menu
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function user_support_page_menu_hook($hook, $type, $return_value, $params) {
	
	if (!elgg_in_context("user_support")) {
		return $return_value;
	}
	
	$return_value[] = ElggMenuItem::factory(array(
		"name" => "faq",
		"text" => elgg_echo("user_support:menu:faq"),
		"href" => "user_support/faq",
	));
	
	$user = elgg_get_logged_in_user_entity();
	if (empty($user)) {
		return $return_value;
	}
	
	$return_value[] = ElggMenuItem::factory(array(
		"name" => "support_ticket_mine",
		"text" => elgg_echo("user_support:menu:support_tickets:mine"),
		"href" => "user_support/support_ticket/owner/" . $user->username,
		"context" => "user_support"
	));
	
	return $return_value;
}

/**
 * Add to the user support menu
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function user_support_user_support_menu_hook($hook, $type, $return_value, $params) {
	
	$user = elgg_get_logged_in_user_entity();
	if (empty($user)) {
		return $return_value;
	}
	
	$post_fix = "";
	if ($q = get_input("q")) {
		$post_fix = "?q=" . $q;
	}
	
	$return_value[] = ElggMenuItem::factory(array(
		"name" => "mine",
		"text" => elgg_echo("user_support:menu:support_tickets:mine"),
		"href" => "user_support/support_ticket/owner/" . $user->username . $post_fix
	));

	$return_value[] = ElggMenuItem::factory(array(
		"name" => "my_archive",
		"text" => elgg_echo("user_support:menu:support_tickets:mine:archive"),
		"href" => "user_support/support_ticket/owner/" . $user->username . "/archive" . $post_fix
	));
	
	if (user_support_staff_gatekeeper(false)) {
		// filter menu
		$return_value[] = ElggMenuItem::factory(array(
			"name" => "all",
			"text" => elgg_echo("user_support:menu:support_tickets"),
			"href" => "user_support/support_ticket" . $post_fix
		));
		
		$return_value[] = ElggMenuItem::factory(array(
			"name" => "archive",
			"text" => elgg_echo("user_support:menu:support_tickets:archive"),
			"href" => "user_support/support_ticket/archive" . $post_fix
		));
	}
	
	return $return_value;
}

/**
 * Add to the owner block menu
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function user_support_owner_block_menu_hook($hook, $type, $return_value, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$entity = elgg_extract("entity", $params);
	
	if (elgg_instanceof($entity, "group")) {
		if ($entity->faq_enable == "yes") {
			$return_value[] = ElggMenuItem::factory(array(
				"name" => "faq",
				"text" => elgg_echo("user_support:menu:faq:group"),
				"href" => "user_support/faq/group/" . $entity->getGUID() . "/all"
			));
		}
	} elseif (elgg_instanceof($entity, "user")) {
		if ($entity->getGUID() == elgg_get_logged_in_user_guid()) {
			$return_value[] = ElggMenuItem::factory(array(
				"name" => "support_ticket_mine",
				"text" => elgg_echo("user_support:menu:support_tickets:mine"),
				"href" => "user_support/support_ticket/owner/" . $entity->username
			));
		}
	}
	
	return $return_value;
}

/**
 * Add to the title menu
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function user_support_title_menu_hook($hook, $type, $return_value, $params) {
	
	if (elgg_in_context("faq")) {
		$user = elgg_get_logged_in_user_entity();
		$page_owner = elgg_get_page_owner_entity();
		
		if (!empty($user) && ($user->isAdmin() || (!empty($page_owner) && elgg_instanceof($page_owner, "group") && $page_owner->canEdit()))) {
			$container_guid = elgg_get_site_entity()->getGUID();
			
			if (!empty($page_owner) && elgg_instanceof($page_owner, "group")) {
				$container_guid = $page_owner->getGUID();
			}
			
			$return_value[] = ElggMenuItem::factory(array(
				"name" => "add",
				"text" => elgg_echo("user_support:menu:faq:create"),
				"href" => "user_support/faq/add/" . $container_guid,
				"link_class" => "elgg-button elgg-button-action"
			));
		}
	} elseif (elgg_in_context("support_ticket_title")) {
		$user = elgg_get_logged_in_user_entity();
		
		if (!empty($user)) {
			$return_value[] = ElggMenuItem::factory(array(
				"name" => "add",
				"text" => elgg_echo("user_support:help_center:ask"),
				"href" => "user_support/support_ticket/add",
				"link_class" => "elgg-button elgg-button-action"
			));
		}
	}
	
	return $return_value;
}

/**
 * Return the widget title url
 *
 * @param string $hook         the name of the hook
 * @param string $type         the type of the hook
 * @param string $return_value current return value
 * @param array  $params       supplied params
 *
 * @return string
 */
function user_support_widget_url_hook($hook, $type, $return_value, $params) {
	
	if ($return_value) {
		return $return_value;
	}
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$entity = elgg_extract("entity", $params);
	
	if (empty($entity) || !elgg_instanceof($entity, "object", "widget")) {
		return $return_value;
	}
	
	$owner = $entity->getOwnerEntity();
	
	switch ($entity->handler) {
		case "faq":
			$owner = $entity->getOwnerEntity();
			$link = "user_support/faq";
			if (elgg_instanceof($owner, "group")) {
				$link .= "/group/" . $owner->getGUID() . "/all";
			}
			
			$return_value = $link;
			
			break;
		case "support_ticket":
			$link = "user_support/support_ticket/" . $owner->username;
			if ($entity->filter == UserSupportTicket::CLOSED) {
				$link .= "/archive";
			}
			
			$return_value = $link;
			break;
		case "support_staff":
			$return_value = "user_support/support_ticket";
			break;
	}
	
	return $return_value;
}

/**
 * Add to the user hover menu
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function user_support_user_hover_menu_hook($hook, $type, $return_value, $params) {
	
	$user = elgg_get_logged_in_user_entity();
	if (empty($user) || !$user->isAdmin()) {
		return $return_value;
	}
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$entity = elgg_extract("entity", $params);
	
	if ($entity->getGUID() == $user->getGUID()) {
		return $return_value;
	}
	
	$text = elgg_echo("user_support:menu_user_hover:make_staff");
	if (user_support_staff_gatekeeper(false, $entity->getGUID())) {
		$text = elgg_echo("user_support:menu_user_hover:remove_staff");
	}
	
	$return_value[] = ElggMenuItem::factory(array(
		"name" => "user_support_staff",
		"text" => $text,
		"href" => "action/user_support/support_staff?guid=" . $entity->getGUID(),
		"confirm" => elgg_echo("question:areyousure"),
		"section" => "admin"
	));
	
	return $return_value;
}

/**
 * Add permissions to support staff
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function user_support_permissions_check_hook($hook, $type, $return_value, $params) {
	
	if ($return_value) {
		return $return_value;
	}
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$entity = elgg_extract("entity", $params);
	
	if (empty($entity) || !elgg_instanceof($entity, "object", UserSupportTicket::SUBTYPE)) {
		return $return_value;
	}
	
	$user = elgg_extract("user", $params);
	
	if (empty($user) || !elgg_instanceof($user, "user")) {
		return $return_value;
	}
	
	return user_support_staff_gatekeeper(false, $user->getGUID());
}

/**
 * Add to the annotation menu
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current return value
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function user_support_annotation_menu_hook($hook, $type, $return_value, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$user = elgg_get_logged_in_user_entity();
	if (empty($user)) {
		return $return_value;
	}
	
	$annotation = elgg_extract("annotation", $params);
	if (empty($annotation) || !($annotation instanceof ElggAnnotation)) {
		return $return_value;
	}
	
	$entity = $annotation->getEntity();
	if (empty($entity) || !elgg_instanceof($entity, "object", UserSupportTicket::SUBTYPE)) {
		return $return_value;
	}
	
	if ($user->isAdmin()) {
		$return_value[] = ElggMenuItem::factory(array(
			"name" => "user_support_promote",
			"text" => elgg_echo("user_support:support_ticket:promote"),
			"href" => "user_support/faq/add/" . elgg_get_site_entity()->getGUID() . "?annotation=" . $annotation->id,
			"is_trusted" => true,
			"priority" => 99
		));
	}
	
	if ($annotation->getOwnerGUID() != $user->getGUID()) {
		foreach ($return_value as $index => $menu_item) {
			if ($menu_item->getName() == "delete") {
				unset($return_value[$index]);
			}
		}
	}
	
	return $return_value;
}

/**
 * Get the subscribers to a comment on a support ticket
 *
 * @param string $hook         the name of the hook
 * @param string $type         the type of the hook
 * @param array  $return_value current return value
 * @param array  $params       supplied params
 *
 * @return array
 */
function user_support_get_subscriptions_support_ticket_comment_hook($hook, $type, $return_value, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$event = elgg_extract("event", $params);
	if (empty($event) || !($event instanceof Elgg_Notifications_Event)) {
		return $return_value;
	}
	
	// ignore access
	$ia = elgg_set_ignore_access(true);
	
	// get object
	$object = $event->getObject();
	if (empty($object) || !elgg_instanceof($object, "object", "comment")) {
		elgg_set_ignore_access($ia);
		
		return $return_value;
	}
	
	// get actor
	$actor = $event->getActor();
	if (empty($actor) || !elgg_instanceof($actor, "user")) {
		elgg_set_ignore_access($ia);
		
		return $return_value;
	}
	
	// get the entity the comment was made on
	$entity = $object->getContainerEntity();
	if (empty($entity) || !elgg_instanceof($entity, "object", UserSupportTicket::SUBTYPE)) {
		elgg_set_ignore_access($ia);
		
		return $return_value;
	}
	
	// by default notify nobody
	$return_value = array();
	
	// did the user comment or some other admin/staff
	if ($entity->getOwnerGUID() != $actor->getGUID()) {
		// admin or staff
		elgg_set_ignore_access($ia);
		
		return $return_value;
	}
	
	// get all the admins to notify
	$users = user_support_get_admin_notify_users($entity);
	if (empty($users) || !is_array($users)) {
		elgg_set_ignore_access($ia);
		
		return $return_value;
	}
	
	// pass all the guids of the admins/staff
	foreach ($users as $user) {
		$notification_settings = get_user_notification_settings($user->getGUID());
		if (empty($notification_settings)) {
			continue;
		}
		
		$methods = array();
		foreach ($notification_settings as $method => $subbed) {
			if ($subbed) {
				$methods[] = $method;
			}
		}
		
		if (!empty($methods)) {
			$return_value[$user->getGUID()] = $methods;
		}
	}
	
	// restore access
	elgg_set_ignore_access($ia);
	
	return $return_value;
}

/**
 * Prepare the message that needs to go to the admins for a comment on a support ticket
 *
 * @param string                          $hook         the name of the hook
 * @param string                          $type         the type of the hook
 * @param Elgg_Notifications_Notification $return_value current return value
 * @param array                           $params       supplied params
 *
 * @return Elgg_Notifications_Notification
 */
function user_support_prepare_support_ticket_comment_message_hook($hook, $type, $return_value, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$event = elgg_extract("event", $params);
	if (empty($event) || !($event instanceof Elgg_Notifications_Event)) {
		return $return_value;
	}
	
	// ignore access
	$ia = elgg_set_ignore_access(true);
	
	// get object
	$object = elgg_extract("object", $params);
	if (empty($object) || !elgg_instanceof($object, "object", "comment")) {
		elgg_set_ignore_access($ia);
		
		return $return_value;
	}
	
	// get actor
	$actor = $event->getActor();
	if (empty($actor) || !elgg_instanceof($actor, "user")) {
		elgg_set_ignore_access($ia);
		
		return $return_value;
	}
	
	// get the entity the comment was made on
	$entity = $object->getContainerEntity();
	if (empty($entity) || !elgg_instanceof($entity, "object", UserSupportTicket::SUBTYPE)) {
		elgg_set_ignore_access($ia);
		
		return $return_value;
	}
	
	$language = elgg_extract("language", $params);
	
	$return_value->subject = elgg_echo("user_support:notify:admin:updated:subject", array($entity->title), $language);
	$return_value->summary = elgg_echo("user_support:notify:admin:updated:summary", array($entity->title), $language);
	$return_value->body = elgg_echo("user_support:notify:admin:updated:message", array(
		$actor->name,
		$entity->title,
		$object->description,
		$entity->getURL()
	), $language);
	
	// restore access
	elgg_set_ignore_access($ia);
	
	return $return_value;
}

/**
 * Get the subscribers to the creation of a support ticket
 *
 * @param string $hook         the name of the hook
 * @param string $type         the type of the hook
 * @param array  $return_value current return value
 * @param array  $params       supplied params
 *
 * @return array
 */
function user_support_get_subscriptions_support_ticket_hook($hook, $type, $return_value, $params) {
	
	if (empty($params) || !is_array($params)) {
		return $return_value;
	}
	
	$event = elgg_extract("event", $params);
	if (empty($event) || !($event instanceof Elgg_Notifications_Event)) {
		return $return_value;
	}
	
	// ignore access
	$ia = elgg_set_ignore_access(true);
	
	// get object
	$object = $event->getObject();
	if (empty($object) || !elgg_instanceof($object, "object", UserSupportTicket::SUBTYPE)) {
		elgg_set_ignore_access($ia);
	
		return $return_value;
	}
	
	// by default notify nobody
	$return_value = array();
	
	// get all the admins to notify
	$users = user_support_get_admin_notify_users($object);
	if (empty($users) || !is_array($users)) {
		elgg_set_ignore_access($ia);
	
		return $return_value;
	}
	
	// pass all the guids of the admins/staff
	foreach ($users as $user) {
		$notification_settings = get_user_notification_settings($user->getGUID());
		if (empty($notification_settings)) {
			continue;
		}
	
		$methods = array();
		foreach ($notification_settings as $method => $subbed) {
			if ($subbed) {
				$methods[] = $method;
			}
		}
	
		if (!empty($methods)) {
			$return_value[$user->getGUID()] = $methods;
		}
	}
	
	// restore access
	elgg_set_ignore_access($ia);
	
	return $return_value;
}

/**
 * Prepare the message that needs to go to the admins for a comment on a support ticket
 *
 * @param string                          $hook         the name of the hook
 * @param string                          $type         the type of the hook
 * @param Elgg_Notifications_Notification $return_value current return value
 * @param array                           $params       supplied params
 *
 * @return Elgg_Notifications_Notification
 */
function user_support_prepare_support_ticket_message_hook($hook, $type, $return_value, $params) {

	if (empty($params) || !is_array($params)) {
		return $return_value;
	}

	$event = elgg_extract("event", $params);
	if (empty($event) || !($event instanceof Elgg_Notifications_Event)) {
		return $return_value;
	}

	// ignore access
	$ia = elgg_set_ignore_access(true);

	// get object
	$object = elgg_extract("object", $params);
	if (empty($object) || !elgg_instanceof($object, "object", UserSupportTicket::SUBTYPE)) {
		elgg_set_ignore_access($ia);

		return $return_value;
	}

	// get actor
	$actor = $event->getActor();
	if (empty($actor) || !elgg_instanceof($actor, "user")) {
		elgg_set_ignore_access($ia);

		return $return_value;
	}

	$language = elgg_extract("language", $params);

	$return_value->subject = elgg_echo("user_support:notify:admin:create:subject", array($object->title), $language);
	$return_value->summary = elgg_echo("user_support:notify:admin:create:summary", array($object->title), $language);
	$return_value->body = elgg_echo("user_support:notify:admin:create:message", array(
		$actor->name,
		$object->description,
		$object->getURL()
	), $language);

	// restore access
	elgg_set_ignore_access($ia);

	return $return_value;
}