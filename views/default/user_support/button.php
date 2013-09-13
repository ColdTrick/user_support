<?php
if (!elgg_in_context("admin")) {
	$help_context = user_support_get_help_context();
	$contextual_help_object = user_support_get_help_for_context($help_context);

	$faq_options = array(
		"type" => "object",
		"subtype" => UserSupportFAQ::SUBTYPE,
		"site_guids" => false,
		"count" => true,
		"metadata_name_value_pairs" => array("help_context" => $help_context)
	);
	
	if(!empty($contextual_help_object)){
		$img_src = $vars["url"] . "mod/user_support/_graphics/help_center/helpcenter16.png";
	} elseif(elgg_get_entities_from_metadata($faq_options) > 0) {
		$img_src = $vars["url"] . "mod/user_support/_graphics/help_center/helpcenter16.png";
	} else {
		$img_src = $vars["url"] . "mod/user_support/_graphics/help_center/helpcenter16_gray.png";
	}

	elgg_load_js("lightbox");
	elgg_load_css("lightbox");

	?>
	<div id="user_support_button" title="<?php echo elgg_echo("user_support:button:hover");?>">
		<a href="<?php echo $vars["url"]; ?>user_support/help_center" class="elgg-lightbox">
			<?php
			foreach(str_split(strtoupper(elgg_echo("user_support:button:text"))) as $char){
				echo $char . "<br />";
			}
			?>
		</a>
		<div>
			<img src="<?php echo $img_src; ?>" />
		</div>
	</div>
	<?php
}
