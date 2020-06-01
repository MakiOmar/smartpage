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

	<div id="anony-preloader">
		<p><?= $blogname ?> <?= esc_html__('Loading...', ANONY_TEXTDOM) ?></p>
		<img class="anony-loader-img" src="<?= $logo_url ?>" alt="<?= $blogname ?>"/>
	</div>
	<div id="anony-hidden-search-form">
	
		<a class="anony-search-form-toggle" href="#" title="Scroll page">
			<i class="fa fa-search"></i>
		</a>
		<?php get_search_form() ?>
	</div>

	<div id="anony-grid-wrapper">

		<div class="anony-grid">

			<div class="anony-grid-col-">

				<header class="white-bg">

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
					
					<!-- Mobile Navigation menu toggle -->
					<div id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></div>

				</header>
			</div>
		</div>