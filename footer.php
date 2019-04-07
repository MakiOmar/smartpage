<footer class="grid-col-md-12 grid-col">

	<p><?php printf(__('All rights reserved for %s 2018',TEXTDOM),get_bloginfo()) ?></p>
	
</footer>

<div id="page-scroll-wrapper">

	<div id="page-scroll-bg"></div>
	
	<a href="#" id="page-scroll"><i class="fa fa-angle-down fa-3x"></i></a>
	
</div>

</div>

<input type="hidden" id="smpg_ajax_url" value="<?php echo smpg_get_ajax_url(); ?>" />

<?php wp_footer();?>

</body>

</html>

<?php
// end output buffering and send our HTML to the browser as a whole
ob_end_flush();
?>
