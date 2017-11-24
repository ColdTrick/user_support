define(function(require){
	
	var $ = require('jquery');
	var Ajax = require('elgg/Ajax');
	var lightbox = require('elgg/lightbox');
	
	var show_form = function() {
		var $help_center = $('.user-support-help-center-popup');
		
		if ($help_center.find('#user-support-help-search-result-wrapper').not(':visible')) {
			$help_center.find('#user-support-help-search-result-wrapper').removeClass('hidden');
			$help_center.find('.user-support-help-center-section').addClass('hidden');
			
			$help_center.find('.elgg-form-user-support-help-center-search input[type="reset"]').removeClass('hidden');
		}
		
		lightbox.resize();
	};
	
	var reset_form = function() {
		var $help_center = $('.user-support-help-center-popup');
		
		if ($help_center.find('#user-support-help-search-result-wrapper').is(':visible')) {
			$help_center.find('#user-support-help-search-result-wrapper').addClass('hidden').html('');
			$help_center.find('.user-support-help-center-section').removeClass('hidden');
			
			$help_center.find('.elgg-form-user-support-help-center-search input[type="reset"]').addClass('hidden');
		}
		
		lightbox.resize();
	};
	
	var submit_form = function(event) {
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
	
	var init = function() {
		$(document).on('submit', '.user-support-help-center-popup form.elgg-form-user-support-help-center-search', submit_form);
		$(document).on('reset', '.user-support-help-center-popup form.elgg-form-user-support-help-center-search', reset_form);
	};
	
	init();
});
