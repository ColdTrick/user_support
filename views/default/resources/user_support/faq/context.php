<?php

use Elgg\Exceptions\Http\BadRequestException;

$help_context = get_input('help_context');
if (empty($help_context)) {
	throw new BadRequestException();
}

elgg_push_collection_breadcrumbs('object', \UserSupportFAQ::SUBTYPE);

$content = elgg_list_entities([
	'type' => 'object',
	'subtype' => \UserSupportFAQ::SUBTYPE,
	'metadata_name_value_pairs' => [
		[
			'name' => 'help_context',
			'value' => $help_context,
		],
	],
	'no_results' => elgg_echo('user_support:faq:not_found'),
]);

echo elgg_view_page(elgg_echo('user_support:faq:context'), [
	'content' => $content,
	'filter' => false,
]);
