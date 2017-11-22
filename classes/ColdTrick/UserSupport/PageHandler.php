<?php

namespace ColdTrick\UserSupport;

class PageHandler {
	
	/**
	 * Handle /user_support URLs
	 *
	 * @param array $page URL segments
	 *
	 * @return bool
	 */
	public static function userSupport($page) {
		
		$vars = [];
		
		switch (elgg_extract(0, $page)) {
			case 'help':
				// @todo make this work
				break;
			case 'faq':
				
				if (!empty($page[2]) && is_numeric($page[2])) {
					$vars['guid'] = $page[2];
				}
				
				elgg_push_breadcrumb(elgg_echo('user_support:menu:faq'), 'user_support/faq');
				
				switch (elgg_extract(1, $page)) {
					case 'edit':
						
						echo elgg_view_resource('user_support/faq/edit', $vars);
						return true;
						
						break;
					case 'group':
						
						echo elgg_view_resource('user_support/faq/group', $vars);
						return true;
						
						break;
					case 'add':
						
						echo elgg_view_resource('user_support/faq/add', $vars);
						return true;
						
						break;
					case 'view':
						
						echo elgg_view_resource('user_support/faq/view', $vars);
						return true;
						
						break;
					default:
						if (!empty($page[1]) && is_numeric($page[1])) {
							register_error(elgg_echo('changebookmark'));
							forward("user_support/faq/view/{$page[1]}");
						}
						
						echo elgg_view_resource('user_support/faq/list');
						return true;
						
						break;
				}
				break;
			case 'support_ticket':
				
				switch (elgg_extract(1, $page)) {
					case 'edit':
						
						if (!empty($page[2]) && is_numeric($page[2])) {
							$vars['guid'] = $page[2];
						}
						
						echo elgg_view_resource('user_support/support_ticket/edit', $vars);
						return true;
						
						break;
					case 'archive':
						
						echo elgg_view_resource('user_support/support_ticket/archive');
						return true;
						
						break;
					case 'owner':
						
						$vars['username'] = elgg_extract(2, $page);
						if (elgg_extract(3, $page) === 'archive') {
							$vars['status'] = \UserSupportTicket::CLOSED;
						}
						
						echo elgg_view_resource('user_support/support_ticket/owner', $vars);
						return true;
						
						break;
					case 'add':
						
						echo elgg_view_resource('user_support/support_ticket/add');
						return true;
						
						break;
					case 'view':
						
						if (!empty($page[2]) && is_numeric($page[2])) {
							$vars['guid'] = $page[2];
						}
						
						echo elgg_view_resource('user_support/support_ticket/view', $vars);
						return true;
						
						break;
					default:
							
						if (!empty($page[1]) && is_numeric($page[1])) {
							register_error(elgg_echo('changebookmark'));
							forward("user_support/support_ticker/view/{$page[1]}");
						}
						
						echo elgg_view_resource('user_support/support_ticket/list');
						return true;
						
						break;
				}
				break;
			case 'help_center':
				
				echo elgg_view_resource('user_support/help_center');
				return true;
				
				break;
			case 'search':
				
				echo elgg_view_resource('user_support/search');
				return true;
				
				break;
		}
		
		return false;
	}
}
