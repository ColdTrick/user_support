define(['jquery', 'elgg/Ajax', 'elgg/lightbox'], function($, Ajax, lightbox) {
	function show_form() {
		var $help_center = $('.user-support-help-center-popup');
		
		if ($help_center.find('#user-support-help-search-result-wrapper').not(':visible')) {
			$help_center.find('#user-support-help-search-result-wrapper').removeClass('hidden');
			$help_center.find('.user-support-help-center-section').addClass('hidden');
			
			$help_center.find('.elgg-form-user-support-help-center-search input[type="reset"]').removeClass('hidden');
		}
		
		lightbox.resize();
	};
	
	function reset_form() {
		var $help_center = $('.user-support-help-center-popup');
		
		if ($help_center.find('#user-support-help-search-result-wrapper').is(':visible')) {
			$help_center.find('#user-support-help-search-result-wrapper').addClass('hidden').html('');
			$help_center.find('.user-support-help-center-section').removeClass('hidden');
			
			$help_center.find('.elgg-form-user-support-help-center-search input[type="reset"]').addClass('hidden');
		}
		
		lightbox.resize();
	};
	
	function submit_form(event) {
		event.preventDefault();
		
		var $form = $(this);
		
		var ajax = new Ajax();
		ajax.path($form.prop('action'), {
			data: ajax.objectify($form),
			success: function(data) {
				var $help_center = $('.user-support-help-center-popup');
				$help_center.find('#user-support-help-search-result-wrapper').html(data);
				
				show_form();
			}
		});
	};
	
	$(document).on('submit', '.user-support-help-center-popup form.elgg-form-user-support-help-center-search', submit_form);
	$(document).on('reset', '.user-support-help-center-popup form.elgg-form-user-support-help-center-search', reset_form);
});
