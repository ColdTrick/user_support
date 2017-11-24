
elgg.provide("elgg.user_support");

elgg.user_support.search = function(event) {
	if (event.which == $.ui.keyCode.ENTER) {
		$('#user_support_help_search_result_wrapper').hide();
		
		elgg.ajax("user_support/search/?q=" + $(this).val(), function(data) {
			$('#user_support_help_search_result_wrapper').html(data).show();
			elgg.user_support.lightbox_resize();
		});
	}
};

elgg.user_support.lightbox_resize = function() {
	$.colorbox.resize();
};

elgg.user_support.init = function() {
	
	$(document).on("keypress", "#user-support-help-center-search", elgg.user_support.search);
	
	elgg.ui.registerTogglableMenuItems('user-support-staff-make', 'user-support-staff-remove');
};

elgg.register_hook_handler('init', 'system', elgg.user_support.init);
