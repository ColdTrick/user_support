<?php
/**
 * Called when the plugin is deactivated
 */

update_subtype('object', \UserSupportFAQ::SUBTYPE);
update_subtype('object', \UserSupportHelp::SUBTYPE);
update_subtype('object', \UserSupportTicket::SUBTYPE);
