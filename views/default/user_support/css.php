<?php 

	$graphics_folder = $vars["url"] . "mod/user_support/_graphics/";

?>

#user_support_button {
	background: transparent url(<?php echo $vars["url"]; ?>mod/user_support/_graphics/button_bg.png) top right repeat-y;
	border-color: #B6B6B6;
	border-style: solid;
	border-width: 1px 1px 1px 0px;
	
	-moz-border-radius-topright:8px;
	-moz-border-radius-bottomright:8px;
	-webkit-border-top-right-radius:8px;
	-webkit-border-bottom-right-radius:8px;
	
	font-size: 16px;
    font-weight: bold;
    left: 0;
    position: fixed;
    padding: 4px 0 4px 4px;
    line-height: 18px;
    text-align: left;
    top: 100px;
    width: 18px;
    z-index: 10000;
}

#user_support_button a {
	color: #FFFFFF;
	text-decoration: none;    
}

#user_support_button img {
    margin-left: -1px;
    padding-top: 10px;
}

#user_support_button a:hover {
	color: #000;
}


/* Forms */

#user_support_help_edit_form_wrapper,
#user_support_ticket_edit_form_wrapper,
#user_support_help_search_result_wrapper {
	display: none;
}

/* Help Center */
#user_support_help_center {
	width: 650px;
}

#user_support_help_center_logo {
	background: transparent url(<?php echo $graphics_folder; ?>help_center/helpcenter64.png) top left no-repeat;
	width: 64px;
	height: 64px;
	float: right;
}

#user_support_help_center div.tags,
div.user_support_tags {
	background: url("<?php echo $vars["url"]; ?>_graphics/icon_tag.gif") no-repeat scroll left 2px transparent;
    min-height: 22px;
    padding: 0 0 0 16px;
}

#user_support_help_center_search{
	background: transparent url(<?php echo $graphics_folder; ?>help_center/find.png) top right no-repeat;
	border: 1px solid #CCCCCC;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	display: inline-block;
	margin: 5px 0 0;
    padding: 0 15px 0 5px;
    width: 250px;
}

#user_support_help_center_search input[name='q']{
	border: none;
	background: none;
	padding: 0px;
	width: 100%;
}

#user_support_help_center h3.settings > span {
	float: right;
	font-size: 80%;
	font-weight: normal;
}

#user_support_help_center_help {
	max-height: 250px;
	overflow-x: hidden;
}

.user_support_full_entity {
	margin-top: 10px;
}

.user_support_full_entity h3 {
 	font-size: 150%;
	margin: 0 0 10px 0;
	padding: 0;
 }

.user_support_full_entity .user_support_entity_owner_icon {
	float: left;
	margin: 3px 0 0 0;
	padding: 0;
}

.user_support_full_entity .user_support_strapline {
	margin: 0 0 0 35px;
	padding: 0;
	color: #aaa;
	line-height: 1em;
}
.user_support_list_entity {
	float: left;
	width: 100%;
}	
.user_support_list_entity .user_support_strapline {
	padding: 0;
	color: #aaa;
}

.user_support_full_entity .user_support_tags {
	margin-left: 35px;
}

.user_support_full_entity .user_support_entity_actions {
	margin-top: 15px;
}

.user_support_list_entity .user_support_entity_actions {
	float: right;
	font-size: 80%;
}

.river_support_ticket {
	background: url("<?php echo $vars["url"]; ?>_graphics/river_icons/river_icon_comment.gif") no-repeat scroll left -1px transparent;
}