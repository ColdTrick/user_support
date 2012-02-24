<?php 
	global $fancybox_js_loaded;
		
	if(empty($fancybox_js_loaded)){
		$fancybox_js_loaded = true;
?>
<script type="text/javascript" src="<?php echo $vars["url"];?>mod/user_support/vendors/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<?php }?>