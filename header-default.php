<?php
/**
 * Header template
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

$language_atts = get_language_attributes();
$contentType   = get_bloginfo( 'html_type' );
$charSet       = get_bloginfo( 'charset' );
$blogname      = get_bloginfo();
$bodyClass     = 'class="' . join( ' ', get_body_class() ) . '"';
$logo          = anony_get_custom_logo( 'orange' );
$preloader_img = anony_get_custom_logo_url( 'orange' );
$nav           = anony_navigation( 'anony-main-menu' );

?>

<!doctype html>
<html itemscope itemtype="http://schema.org/WebPage" <?php echo $language_atts; ?>>
<head>
<meta http-equiv="Content-Type" content="<?php echo $contentType; ?>" charset="<?php echo $charSet; ?>"/>
<meta http-equiv="x-ua-compatible" content="IE=edge" >
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<?php wp_head(); ?>
</head>

<body <?php echo $bodyClass; ?>>
	 
	<div id="anony-hidden-search-form">
	 
		<a class="anony-search-form-toggle" href="#" title="Search form">
			<i class="fa fa-search"></i>
		</a>
		<?php get_search_form(); ?>
	</div>

	<div id="anony-grid-wrapper">

		<div class="anony-grid">

			<div class="anony-grid-col-">

				<header class="white-bg">
					 
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

					</div>
					<!-- Navigation menu -->
					<?php echo $nav; ?>
					 
					<!-- Mobile Navigation menu toggle -->
					<div id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></div>

				</header>
			</div>
		</div>

