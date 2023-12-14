<footer id="anony-footer" class="anony-grid-col-md-12 anony-grid-col">
	 
	<?php if ( $footer_ad ) : ?>
	 
		<div class="anony-ad">

		<?php do_action( 'footer_ad' ); ?>
		 
		</div>
	 
	<?php endif ?>
	 
	<p><?php echo $copyright; ?></p>
	 
</footer>

<div id="anony-page-scroll-wrapper">

	<div id="anony-page-scroll-bg"></div>
	 
	<a href="#" title="<?php esc_attr_e( 'Page scroll', 'smartpage' ); ?>" id="anony-page-scroll"><i class="fa fa-angle-down fa-3x"></i></a>
	 
</div>

</div>

<input type="hidden" id="anony_ajax_url" value="<?php echo $ajaxUrl; ?>" />

<?php wp_footer(); ?> 
	 
<?php do_action( 'anony_after_page_footer' ); ?>

<?php
if ( $anony_options->compress_html == 1 ) {
	ob_end_flush();
}
?>
</body>

</html>
