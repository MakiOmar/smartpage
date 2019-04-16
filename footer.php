<?php $smpgOptions = Smpg__Options_Model::get_instance();?>

<footer class="grid-col-md-12 grid-col">

	<p><?php echo $smpgOptions->smpg_copyright_settings ?></p>
	
</footer>

<div id="page-scroll-wrapper">

	<div id="page-scroll-bg"></div>
	
	<a href="#" id="page-scroll"><i class="fa fa-angle-down fa-3x"></i></a>
	
</div>

</div>

<input type="hidden" id="smpg_ajax_url" value="<?php echo smpg_get_ajax_url(); ?>" />
<div id="smpg-loading">
    <div id="smpg-page-loading-wrapper"><div id="smpg-page-loading-bg"></div></div>
</div>
<?php wp_footer();?>

</body>

</html>

<?php
// end output buffering and send our HTML to the browser as a whole
ob_end_flush();
?>
