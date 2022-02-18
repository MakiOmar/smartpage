<?php
$anony_options = ANONY_Options_Model::get_instance();

if ($anony_options->dynamic_css_ajax != '1') header( "Content-type: text/css; charset: UTF-8" );

if(is_rtl()){

	$headingFont = $anony_options->anony_headings_ar_font;
	if (!empty($headingFont)) {?>
		h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
			font-family: "<?php echo $headingFont ?>"
		}
	<?php }

	$links_font = $anony_options->anony_links_ar_font;
	if (!empty($links_font)) {?>

		a, .page-numbers, span.meta-text{
			font-family: "<?php echo $links_font ?>"
		}
	<?php } 
	
	$paragraphFont = $anony_options->anony_paragraph_ar_font;
	if (!empty($paragraphFont)) {?>
		p{
			font-family: "<?php echo $paragraphFont ?>"
		}
	<?php } ?>

	
<?php }else{
	$headingFont = $anony_options->anony_headings_en_font;
	if (!empty($headingFont)) {?>
		h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
			font-family: "<?php echo $headingFont ?>"
		}
	<?php }

	$links_font = $anony_options->anony_links_en_font;
	if (!empty($links_font)) {?>

		a,.page-numbers, span.meta-text{
			font-family: "<?php echo $headingFont ?>"
		}
	<?php } 
	
	$paragraphFont = $anony_options->anony_paragraph_en_font;
	if (!empty($paragraphFont)) {?>
		p{
			font-family: "<?php echo $paragraphFont ?>"
		}
	<?php }
 }
?>