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

	
	<?php get_search_form() ?>


	<div id="anony-grid-wrapper">

		<div class="anony-grid">

			<div class="anony-grid-col-">

				<header>

					<?php include(locate_template('templates/header-top.view.php', false, false)) ;?>
					
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

						<?php  endif;?>


					</div>
					<!-- Navigation menu -->
					<?= $nav ?>

				</header>
			</div>
		</div>