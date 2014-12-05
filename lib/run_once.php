<?php
/**
 * Helper script
 */

/**
* This function adds a class handler to object->faq
* Since the old FAQ didn't had a class
*
* @return bool
*/
function user_support_faq_class_update() {
	
	$class = get_subtype_class("object", UserSupportFAQ::SUBTYPE);
	if ($class != "UserSupportFAQ") {
		return update_subtype("object", UserSupportFAQ::SUBTYPE, "UserSupportFAQ");
	}
	
	return true;
}