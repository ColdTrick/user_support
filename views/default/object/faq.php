<?php 

	$entity = $vars["entity"];
	$full_view = $vars["full"];
	
	if(!$full_view){
		$icon = "<img src='" . $entity->getIcon("small") . "' alt='" . $entity->title . "' title='" . $entity->title . "' />";
		
		$info = "<div class='user_support_list_entity'>";
		
		// edit parts
		if($entity->canEdit()) {
			$info .= "<div class='user_support_entity_actions'>";
			$info .= elgg_view("output/url", array("href" => $vars["url"] . "pg/user_support/faq/edit/" . $entity->getGUID(), "text" => elgg_echo("edit")));
			$info .= " | " . elgg_view("output/confirmlink", array("href" => $vars["url"] . "action/user_support/faq/delete?guid=" . $entity->getGUID(), "text" => elgg_echo("delete")));
			$info .= "</div>";
		}
		
		$info .= "<div>" . elgg_echo("user_support:question:short") . ": " . elgg_view("output/url", array("href" => $entity->getURL(), "text" => $entity->title)) . "</div>";
		
		$info .= "<div>";
		$info .= elgg_echo("user_support:anwser:short") . ": " . elgg_get_excerpt($entity->description, 150);
		$info .= " " . elgg_view("output/url", array("href" => $entity->getURL(), "text" => elgg_echo("user_support:read_more")));
		$info .= "</div>";
		
		
		$info .= "</div>";
		$info .= "<div class='clearfloat'></div>";
		
		echo elgg_view_listing($icon, $info);
	} else {
		$owner = $entity->getOwnerEntity();
		
		?>
		<div class="contentWrapper user_support_full_entity">
			<h3><?php echo elgg_echo("user_support:question") . ": " . $entity->title; ?></h3>
			
			<!-- Subtitle info -->
			<div class="user_support_entity_owner_icon">
				<img src="<?php echo $entity->getIcon("tiny"); ?>" alt="<?php echo $entity->title; ?>" title="<?php echo $entity->title; ?>" />
			</div>
			
			<div class="user_support_strapline">
				<?php echo user_support_time_created_string($entity); ?>
			</div>
			
			<?php if(!empty($entity->tags)) { ?>
			<div class="user_support_tags">
				<?php echo elgg_view("output/tags", array("value" => $entity->tags)); ?>
			</div>
			<?php } ?>
			
			<div class="clearfloat"></div>
			
			<!-- main content -->
			<?php 
				echo elgg_echo("user_support:anwser") . ": ";
				echo elgg_view("output/longtext", array("value" => $entity->description));
			?>
			<div class="clearfloat"></div>
			
			<!-- edit parts -->
			<?php if($entity->canEdit()) { ?>
			<div class="user_support_entity_actions">
				<?php 
					echo elgg_view("output/url", array("href" => $vars["url"] . "pg/user_support/faq/edit/" . $entity->getGUID(), "text" => elgg_echo("edit")));
					echo " | " . elgg_view("output/confirmlink", array("href" => $vars["url"] . "action/user_support/faq/delete?guid=" . $entity->getGUID(), "text" => elgg_echo("delete")));
				?>
			</div>
			<?php } ?>
		</div>
		<?php
	}

?>