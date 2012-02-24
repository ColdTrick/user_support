<?php 

	$entity = $vars["entity"];
	$owner = $entity->getOwnerEntity();
	
	$full_view = $vars["full"];
	
	$loggedin_user = get_loggedin_user();

	if(!$full_view){
		// icon
//		$icon = elgg_view("profile/icon", array("entity" => $entity->getOwnerEntity(), "size" => "small"));
		$icon = "<img src='" . $entity->getIcon("small") . "' title='" . $entity->title . "' alt='" . $entity->title . "' />";
		
		// info
		$info = "<div class='user_support_list_entity'>";
		
		// edit actions
		if($entity->canEdit()){
			$info .= "<div class='user_support_entity_actions'>";
			$info .= elgg_view("output/url", array("href" => $vars["url"] . "pg/user_support/support_ticket/edit/" . $entity->getGUID(), "text" => elgg_echo("edit")));
			$info .= " | " . elgg_view("output/confirmlink", array("href" => $vars["url"] . "action/user_support/ticket/delete?guid=" . $entity->getGUID(), "text" => elgg_echo("delete")));
			
			if($loggedin_user->isAdmin()){
				if(($entity->getStatus() == UserSupportTicket::OPEN)){
					$info .= " | " . elgg_view("output/confirmlink", array("href" => $vars["url"] . "action/user_support/ticket/close?guid=" . $entity->getGUID(), "text" => elgg_echo("close")));
				} else {
					$info .= " | " . elgg_view("output/confirmlink", array("href" => $vars["url"] . "action/user_support/ticket/reopen?guid=" . $entity->getGUID(), "text" => elgg_echo("user_support:reopen")));
				}
			}
			
			$info .= "</div>";
		}
		
		// title
		if(!empty($entity->support_type)){
			$info .= elgg_echo("user_support:support_type:" . $entity->support_type) . ": ";
		}
		$info .= elgg_view("output/url", array("href" => $entity->getURL(), "text" => $entity->title));
		
		$info .= "<div class='clearfloat'></div>";
		
		// strapline
		$info .= "<div class='user_support_strapline'>";
		$info .= user_support_time_created_string($entity);
		$info .= " " . elgg_echo("by");
		$info .= " " . elgg_view("output/url", array("href" => $owner->getURL(), "text" => $owner->name));
		
		if($ann = $entity->getAnnotations("generic_comment", 1, 0, "desc")){
			$ann_owner = get_user($ann[0]->owner_guid);
			$url = elgg_view("output/url", array("href" => $ann_owner->getURL(), "text" => $ann_owner->name));
			$info .= ", " . sprintf(elgg_echo("user_support:last_comment"), $url);
		}
		
		$info .= "</div>";
		
		// tags
		if(!empty($entity->tags)){
			$info .= "<div class='user_support_tags'>" . elgg_view("output/tags", array("value" => $entity->tags)) . "</div>";
		}
		
		$info .= "</div>";
		$info .= "<div class='clearfloat'></div>";
		
		echo elgg_view_listing($icon, $info);
	} else {
		?>
		<div class="contentWrapper user_support_full_entity">
			<h3><?php 
				if(!empty($entity->support_type)){
					echo elgg_echo("user_support:support_type:" . $entity->support_type) . ": ";
				}
				
				echo $entity->title; 
			?></h3>
			
			<!-- Subtitle info -->
			<div class="user_support_entity_owner_icon">
				<?php //echo elgg_view("profile/icon", array("entity" => $owner, "size" => "tiny")); ?>
				<img src="<?php echo $entity->getIcon("tiny"); ?>" title="<?php echo $entity->title; ?>" alt="<?php echo $entity->title; ?>" />
			</div>
			
			<div class="user_support_strapline">
				<?php 
					echo user_support_time_created_string($entity);
					echo " " . elgg_echo("by");
					echo " " . elgg_view("output/url", array("href" => $owner->getURL(), "text" => $owner->name));
				?>
			</div>
			
			<?php if(!empty($entity->tags)) { ?>
			<div class="user_support_tags">
				<?php echo elgg_view("output/tags", array("value" => $entity->tags)); ?>
			</div>
			<?php } ?>
			
			<div class="clearfloat"></div>
			
			<!-- main content -->
			<?php 
			if(!empty($entity->help_url)){
				echo elgg_echo("user_support:url") . ": " . elgg_view("output/url", array("href" => $entity->help_url)) . "<br />";
			}
			
			?>
			<div class="clearfloat"></div>
			
			<!-- edit parts -->
			<?php if($entity->canEdit()) { ?>
			<div class="user_support_entity_actions">
				<?php 
					echo elgg_view("output/url", array("href" => $vars["url"] . "pg/user_support/support_ticket/edit/" . $entity->getGUID(), "text" => elgg_echo("edit")));
					echo " | " . elgg_view("output/confirmlink", array("href" => $vars["url"] . "action/user_support/ticket/delete?guid=" . $entity->getGUID(), "text" => elgg_echo("delete")));
					
					if($loggedin_user->isAdmin()){
						if(($entity->getStatus() == UserSupportTicket::OPEN)){
							echo " | " . elgg_view("output/confirmlink", array("href" => $vars["url"] . "action/user_support/ticket/close?guid=" . $entity->getGUID(), "text" => elgg_echo("close")));
						} else {
							echo " | " . elgg_view("output/confirmlink", array("href" => $vars["url"] . "action/user_support/ticket/reopen?guid=" . $entity->getGUID(), "text" => elgg_echo("user_support:reopen")));
						}
					}
				?>
			</div>
			<?php } ?>
			
		</div>
		<?php

		echo elgg_view_comments($entity);
	}
?>