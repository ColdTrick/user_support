<?php 
	global $fancybox_js_loaded;
		
	if(empty($fancybox_js_loaded)){
		$fancybox_js_loaded = true;
?>
<link rel="stylesheet" href="<?php echo $vars["url"];?>mod/widget_manager/vendors/fancybox/jquery.fancybox-1.3.4.css" type="text/css" />
<script type="text/javascript" src="<?php echo $vars["url"];?>mod/widget_manager/vendors/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<?php }?>