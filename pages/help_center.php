<?php

	global $CONFIG;

	$help_url = $_SERVER["HTTP_REFERER"];
	$help_context = user_support_get_help_context($help_url);
	$contextual_help_object = user_support_get_help_for_context($help_context);
	
	if(is_plugin_enabled("groups")){
		$group_guid = (int) get_plugin_setting("help_group_guid", "user_support");
		if(!empty($group_guid) && ($group = get_entity($group_guid))){
			if(!($group instanceof ElggGroup)){
				$group = null;
			}
		}
	}
	
	$faq_options = array(
		"type" => "object",
		"subtype" => UserSupportFAQ::SUBTYPE,
		"site_guids" => false,
		"limit" => 5,
		"metadata_name_value_pairs" => array("name" => "help_context", "value" => $help_context),
		"full_view" => false,
		"pagination" => false
	);
	
	$context = get_context();
	set_context("search");
	
	$faq = elgg_list_entities_from_metadata($faq_options);
	
	set_context($context);

?>
<div class="contentWrapper" id="user_support_help_center">
	<div id="user_support_help_center_header">
		<div id="user_support_help_center_logo"></div>
		<h1><?php echo elgg_echo("user_support:help_center:title"); ?></h1>
		<span id="user_support_help_center_search">
			<input type="text" name="q" value="<?php echo elgg_echo("search"); ?>" title="<?php echo elgg_echo("search"); ?>" />
		</span>
		<div id="user_support_help_center_actions">
			<?php if(isloggedin()){?>
				<input type="button" class="submit_button" value="<?php echo elgg_echo("user_support:help_center:ask"); ?>" onclick="$('#user_support_ticket_edit_form_wrapper').toggle();$.fancybox.resize();" />
				<input type="button" class="submit_button" value="<?php echo elgg_echo("user_support:menu:support_tickets:mine"); ?>" onclick="window.location.href='<?php echo $CONFIG->wwwroot; ?>/pg/user_support/support_ticket/mine';" />
			<?php }?>
			<input type="button" class="submit_button" value="<?php echo elgg_echo("user_support:menu:faq"); ?>" onclick="window.location.href='<?php echo $CONFIG->wwwroot; ?>/pg/user_support/faq';" />
			<?php 
				if(!empty($group)){;
			?>
			<input type="button" class="submit_button" value="<?php echo elgg_echo("user_support:help_center:help_group"); ?>" onclick="window.location.href='<?php echo $group->getURL(); ?>';" />
			<?php } ?>
			<?php if(isadminloggedin() && empty($contextual_help_object)){ ?>
			<input type="button" class="submit_button" value="<?php echo elgg_echo("user_support:help_center:help"); ?>" onclick="$('#user_support_help_edit_form_wrapper').toggle();$.fancybox.resize();" />
			<?php } ?>
		</div>
		<div class="clearfloat"></div>
	</div>
<?php

	if(!empty($contextual_help_object)){
		echo "<h3 class='settings'>";
		if($contextual_help_object->canEdit()){
			echo "<span>";
			echo "<a href='javascript:void(0);' onclick='$(\"#user_support_help_edit_form_wrapper\").toggle();$.fancybox.resize();'>" . elgg_echo("edit") . "</a>";
			echo " | ";
			echo elgg_view("output/confirmlink", array("href" => $CONFIG->wwwroot . "action/user_support/help/delete?guid=" . $contextual_help_object->getGUID(), "text" => elgg_echo("delete")));
			echo "</span>";
		}
		echo "Contextual Help";
		echo "</h3>";
		
		echo "<div id='user_support_help_center_help'>";
		echo elgg_view_entity($contextual_help_object);
		echo "</div>";
	}
	
	if(!empty($faq)){
		echo "<h3 class='settings'>" . elgg_echo("user_support:help_center:faq:title") . "</h3>";
		echo $faq;
	}

	if(isadminloggedin()){
		echo "<div id='user_support_help_edit_form_wrapper'>";
		echo elgg_view("user_support/forms/help", array("help_context" => $help_context, "entity" => $contextual_help_object));
		echo "</div>";
	}
	
	if(isloggedin()){
		echo "<div id='user_support_ticket_edit_form_wrapper'>";
		echo elgg_view("user_support/forms/support_ticket", array("help_context" => $help_context, "help_url" => $help_url));
		echo "</div>";
	}
	echo "<div id='user_support_help_search_result_wrapper'></div>";
	
?>
</div>

<script type="text/javascript">
	$('#user_support_help_center_search input[name="q"]').focus(function(){
			if($(this).val() === $(this).attr("title")){
				$(this).val("");
			}
		}).blur(function(){
			if($(this).val() == ""){
				$(this).val($(this).attr("title"));
			}
		}).keypress(function(event){
			if(event.which == 13){
				$('#user_support_help_search_result_wrapper').hide();
				
				$.post("<?php echo $CONFIG->wwwroot; ?>pg/user_support/search/?q=" + $(this).val(), function(data){
					$('#user_support_help_search_result_wrapper').html(data).show();
				});
			}
		});
</script>