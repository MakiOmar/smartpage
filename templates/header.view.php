<?php
	if ( ! defined( 'ABSPATH' ) ) {
	    exit; // Exit if accessed directly
	}
?>
<!doctype html>
<html itemscope itemtype="http://schema.org/WebPage" <?= $langAtts ?>>
<head>
<meta http-equiv="Content-Type" content="<?= $contentType ?>" charset="<?= $charSet ?>"/>
<meta http-equiv="x-ua-compatible" content="IE=edge" >
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<?php wp_head();?>
</head>

<body <?= $bodyClass?>>
<div id="anony-hidden-search-form">
	
	<a class="anony-search-form-toggle" href="#" title="Scroll page">
		<i class="fa fa-search"></i>
	</a>
	
	<?php get_search_form() ?>
</div>

<div id="anony-grid-wrapper">

	<div class="anony-grid">

		<div class="anony-grid-col-">

				<header>

					<?php get_template_part('templates/top-header') ;?>
					
					<div id="anony-sub-top-wrapper">
					
						<div id="anony-toggles-wrapper">
							<a href="#" id="anony-menu-toggle">
								<i class="fa fa-bars fa-2x" aria-hidden="true"></i>
							</a>

							<a class="anony-search-form-toggle" href="#">
								<i class="fa fa-search"></i>
							</a>
						</div>

						 <?= $logo ?>

						 <?php if(has_action('header_ad')) : ?>

							<div id="anony-ads" class="anony-grid-col-md-6 anony-grid-col-sm-6">

								<?php do_action('header_ad'); ?>

							</div>

						<?php  endif;

						if(function_exists('anony_user_main')) :?>
								 
							<div class="anony-grid-col-md-3 anony-grid-col-sm-3">

							 <!--User control plugin's menu
							 echo anony_user_main('anony-user-control');-->

							</div>

						<?php endif ?>

					</div>
					<!-- Navigation menu -->
					<?= $nav ?>

				</header>
		</div>
	</div>