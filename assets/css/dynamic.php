<?php
$anonyOptions = ANONY_Options_Model::get_instance();

if ($anonyOptions->dynamic_css_ajax != '1') header( "Content-type: text/css; charset: UTF-8" );

if(is_rtl()){

	$headingFont = $anonyOptions->anony_headings_ar_font;
	if (!empty($headingFont)) {?>
		h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
			font-family: "<?php echo $headingFont ?>"
		}
	<?php }

	$links_font = $anonyOptions->anony_links_ar_font;
	if (!empty($links_font)) {?>

		a, .page-numbers, span.meta-text{
			font-family: "<?php echo $links_font ?>"
		}
	<?php } 
	
	$paragraphFont = $anonyOptions->anony_paragraph_ar_font;
	if (!empty($paragraphFont)) {?>
		p{
			font-family: "<?php echo $paragraphFont ?>"
		}
	<?php } ?>

	
<?php }else{
	$headingFont = $anonyOptions->anony_headings_en_font;
	if (!empty($headingFont)) {?>
		h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
			font-family: "<?php echo $headingFont ?>"
		}
	<?php }

	$links_font = $anonyOptions->anony_links_en_font;
	if (!empty($links_font)) {?>

		a,.page-numbers, span.meta-text{
			font-family: "<?php echo $headingFont ?>"
		}
	<?php } 
	
	$paragraphFont = $anonyOptions->anony_paragraph_en_font;
	if (!empty($paragraphFont)) {?>
		p{
			font-family: "<?php echo $paragraphFont ?>"
		}
	<?php }
 }
?>