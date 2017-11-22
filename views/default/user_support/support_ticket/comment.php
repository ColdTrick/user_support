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

echo elgg_view('input/submit', [
	'name' => 'support_ticket_comment_close',
	'value' => elgg_echo('user_support:comment_close'),
	'id' => 'user-support-ticket-comment-close',
	'class' => 'elgg-button-submit mhs',
]);
?>
<script type='text/javascript'>
	var $button = $('#user-support-ticket-comment-close');
	var $form = $button.parents('.elgg-form-comment-save');

	$form.find('div.elgg-foot input[type=submit]').after($button);
</script>
