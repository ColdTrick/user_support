/* UserSupport JS */
elgg.provide('elgg.user_support');

elgg.user_support.init = function() {	
	elgg.ui.registerTogglableMenuItems('user-support-staff-make', 'user-support-staff-remove');
};

elgg.register_hook_handler('init', 'system', elgg.user_support.init);
