<?php global $anonyOptions;?>

<footer class="anony-grid-col-md-12 anony-grid-col">
	<?php 
		if(has_action('footer_ad')){
			do_action('footer_ad');
		}
	?>
	
	<p><?php echo esc_html($anonyOptions->copyright) ?></p>
	
</footer>

<div id="anony-page-scroll-wrapper">

	<div id="anony-page-scroll-bg"></div>
	
	<a href="#" id="anony-page-scroll"><i class="fa fa-angle-down fa-3x"></i></a>
	
</div>

</div>

<input type="hidden" id="anony_ajax_url" value="<?php echo anony_get_ajax_url(); ?>" />
<div id="anony-loading">
    <div id="anony-page-loading-wrapper"><div id="anony-page-loading-bg"></div></div>
</div>
<?php wp_footer();?>

</body>

</html>

<?php
// end output buffering and send our HTML to the browser as a whole
ob_end_flush();
?>
