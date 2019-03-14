<?php
/**
 * Extends the comment form with an extra button
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof UserSupportTicket) {
	return;
}

if ($entity->getStatus() !== UserSupportTicket::OPEN) {
	return;
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'support_ticket_comment_close',
	'value' => 1,
	'disabled' => true,
]);

echo elgg_view('input/submit', [
	'value' => elgg_echo('user_support:comment_close'),
	'id' => 'user-support-ticket-comment-close',
	'class' => 'elgg-button-submit mhs hidden',
]);
?>
<script type='text/javascript'>
	require(['jquery'], function($) {
		var $button = $('#user-support-ticket-comment-close');
		var $form = $button.closest('.elgg-form-comment-save');
	
		$form.find('.elgg-form-footer').append($button);
		$button.removeClass('hidden');

		$button.on('click', function() {
			$form.find('input[name="support_ticket_comment_close"]').prop('disabled', false);
		});
	});
</script>
