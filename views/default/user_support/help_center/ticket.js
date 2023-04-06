define(['jquery', 'elgg/Ajax', 'elgg/lightbox'], function($, Ajax, lightbox) {
	function toggle_ticket_form() {
		var $help_center = $('.user-support-help-center-popup');
		
		if ($help_center.find('#user-support-ticket-edit-form-wrapper').is(':visible')) {
			$help_center.find('#user-support-ticket-edit-form-wrapper').addClass('hidden');
			$help_center.find('.user-support-help-center-section').removeClass('hidden');
		} else {
			$help_center.find('#user-support-ticket-edit-form-wrapper').removeClass('hidden');
			$help_center.find('.user-support-help-center-section').addClass('hidden');
		}
		
		lightbox.resize();
	};
	
	function submit_ticket_form(event) {
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
	
	$(document).on('click', '#user-support-help-center-ask', toggle_ticket_form);
	$(document).on('click', '#user-support-edit-ticket-cancel', toggle_ticket_form);
	$(document).on('submit', '#user-support-ticket-edit-form-wrapper form.elgg-form-user-support-support-ticket-edit', submit_ticket_form);
});
