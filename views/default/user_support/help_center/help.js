define(['jquery', 'elgg/Ajax', 'elgg/lightbox'], function($, Ajax, lightbox) {
	
	function toggle_help_form() {
		var $help_center = $('.user-support-help-center-popup');
		
		if ($help_center.find('#user-support-help-edit-form-wrapper').is(':visible')) {
			$help_center.find('#user-support-help-edit-form-wrapper').addClass('hidden');
			$help_center.find('.user-support-help-center-section').removeClass('hidden');
		} else {
			$help_center.find('#user-support-help-edit-form-wrapper').removeClass('hidden');
			$help_center.find('.user-support-help-center-section').addClass('hidden');
		}
		
		lightbox.resize();
	};
	
	function submit_help_form(event) {
		event.preventDefault();
		
		var $form = $(this);
		
		var ajax = new Ajax();
		ajax.action($form.prop('action'), {
			data: ajax.objectify($form),
			success: function() {
				lightbox.close();
			}
		});
	};
	
	// edit link .user-support-help-center-edit-help
	// add button #user-support-help-center-add-help
	$(document).on('click', '#user-support-help-center-add-help', toggle_help_form);
	$(document).on('click', '.user-support-help-center-edit-help', toggle_help_form);
	$(document).on('click', '#user-support-edit-help-cancel', toggle_help_form);
	$(document).on('submit', '#user-support-help-edit-form-wrapper form.elgg-form-user-support-help-edit', submit_help_form);
});
