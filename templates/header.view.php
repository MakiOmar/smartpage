<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
?>
<!doctype html>
<html itemscope itemtype="http://schema.org/WebPage" <?php echo $langAtts; ?>>
<head>
<meta http-equiv="Content-Type" content="<?php echo $contentType; ?>" charset="<?php echo $charSet; ?>"/>
<meta http-equiv="x-ua-compatible" content="IE=edge" >
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<?php wp_head(); ?>
</head>

<body <?php echo $bodyClass; ?>>
	 
	<?php if ( $preloader == '1' ) : ?>
		<div id="anony-preloader">
			<p><?php echo $blogname; ?> <?php echo esc_html__( 'Loading...', 'smartpage' ); ?></p>
			<div class="anony-loader-img"><img src="<?php echo $preloader_img; ?>" alt="<?php echo $blogname; ?>"/></div>
		</div>
	<?php endif ?>
	 
	<div id="anony-hidden-search-form">
	 
		<a class="anony-search-form-toggle" href="#" title="Scroll page">
			<i class="fa fa-search"></i>
		</a>
		<?php get_search_form(); ?>
	</div>

	<div id="anony-grid-wrapper">

		<div class="anony-grid">

			<div class="anony-grid-col-">

				<header class="white-bg">

					<?php require locate_template( 'templates/header-top.view.php', false, false ); ?>
					 
					<div id="anony-sub-top-wrapper">
					 
						<div id="anony-toggles-wrapper">
							<a href="#" id="anony-menu-toggle">
								<i class="fa fa-bars fa-2x" aria-hidden="true"></i>
							</a>

							<a class="anony-search-form-toggle" href="#">
								<i class="fa fa-search"></i>
							</a>
						</div>

						 <?php echo $logo; ?>

						 <?php if ( has_action( 'header_ad' ) ) : ?>

							<div id="anony-ads" class="anony-grid-col-md-6 anony-grid-col-sm-6">

								<?php do_action( 'header_ad' ); ?>

							</div>

						 <?php endif; ?>


					</div>
					<!-- Navigation menu -->
					<?php echo $nav; ?>
					 
					<!-- Mobile Navigation menu toggle -->
					<div id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></div>

				</header>
			</div>
		</div>
