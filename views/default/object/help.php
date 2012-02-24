<?php 

	$entity = $vars["entity"];
	$full_view = $vars["full"];
	
	if(!$full_view){
		if(!empty($entity->tags)){
			echo "<div class='tags'>" . elgg_view("output/tags", array("value" => $entity->tags)) . "</div>";
		}
		echo "<div>" . elgg_view("output/longtext", array("value" => $entity->description)) . "</div>";
	}
	
?>