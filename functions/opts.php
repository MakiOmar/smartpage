<?php

$smpgOptions = Smpg__Options_Model::get_instance();

add_action('wp_head', function() use($smpgOptions){?>
	<style type="text/css">
		<?php
			if(is_rtl()){?>
				h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
					font-family: "<?php echo $smpgOptions->smpg_headings_ar_font ?>"
				}

				a{
					font-family: "<?php echo $smpgOptions->smpg_paragraph_ar_font ?>"
				}
				p{
					font-family: "<?php echo $smpgOptions->smpg_paragraph_ar_font ?>"
				}
			<?php }
	
			if(!is_rtl()){?>
				h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
					font-family: "<?php echo $smpgOptions->smpg_headings_en_font ?>"
				}
				a{
					font-family: "<?php echo $smpgOptions->smpg_links_en_font ?>"
				}
				p{
					font-family: "<?php echo $smpgOptions->smpg_paragraph_en_font ?>"
				}
			<?php }
		?>
	</style>
<?php });