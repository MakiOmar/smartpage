<footer class="anony-grid-col-md-12 anony-grid-col">
	<?php do_action('footer_ad');?>
	
	<p><?= $copyright  ?></p>
	
</footer>

<div id="anony-page-scroll-wrapper">

	<div id="anony-page-scroll-bg"></div>
	
	<a href="#" id="anony-page-scroll"><i class="fa fa-angle-down fa-3x"></i></a>
	
</div>

</div>

<input type="hidden" id="anony_ajax_url" value="<?= $ajaxUrl ?>" />

<div id="anony-loading">
    <div id="anony-page-loading-wrapper"><div id="anony-page-loading-bg"></div></div>
</div>

<?php wp_footer(); ?> 
	
<?php do_action( 'anony_after_page_footer' );?>

</body>

</html>
