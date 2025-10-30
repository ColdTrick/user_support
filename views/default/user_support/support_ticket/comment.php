<?php
/**
 * Extends the comment form with an extra button
 */

$entity = elgg_extract('entity', $vars);
if (!$entity instanceof \UserSupportTicket) {
	return;
}

if ($entity->getStatus() !== \UserSupportTicket::OPEN) {
	return;
}

echo elgg_view_field([
	'#type' => 'hidden',
	'name' => 'support_ticket_comment_close',
	'value' => 1,
	'disabled' => true,
]);

echo elgg_view_field([
	'#type' => 'submit',
	'#class' => 'user-support-ticket-comment-close hidden',
	'text' => elgg_echo('user_support:comment_close'),
]);
?>
<script type='module'>
	import 'jquery';
	
	var $button = $('.user-support-ticket-comment-close');
	var $form = $button.closest('.elgg-form-comment-save');

	$form.find('.elgg-form-footer .elgg-field-submit').after($button);
	$button.removeClass('hidden');

	$button.find('button').on('click', function() {
		$form.find('input[name="support_ticket_comment_close"]').prop('disabled', false);
	});
</script>
