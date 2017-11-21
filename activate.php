<?php
/**
 * Called when the plugin is activated
 */

if (!get_subtype_id('object', \UserSupportFAQ::SUBTYPE)) {
	add_subtype('object', \UserSupportFAQ::SUBTYPE, \UserSupportFAQ::class);
} else {
	update_subtype('object', \UserSupportFAQ::SUBTYPE, \UserSupportFAQ::class);
}

if (!get_subtype_id('object', \UserSupportHelp::SUBTYPE)) {
	add_subtype('object', \UserSupportHelp::SUBTYPE, \UserSupportHelp::class);
} else {
	update_subtype('object', \UserSupportHelp::SUBTYPE, \UserSupportHelp::class);
}

if (!get_subtype_id('object', \UserSupportTicket::SUBTYPE)) {
	add_subtype('object', \UserSupportTicket::SUBTYPE, \UserSupportTicket::class);
} else {
	update_subtype('object', \UserSupportTicket::SUBTYPE, \UserSupportTicket::class);
}
