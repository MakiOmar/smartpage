<?php
// start output buffering at the top of our script with this simple command
// we've added "ob_gzhandler" as a parameter of ob_start
ob_start('ob_gzhandler');
?>
<!doctype html>
<html itemscope itemtype="http://schema.org/WebPage" <?php language_attributes()?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>" charset="<?php bloginfo( 'charset' ); ?>"/>
<meta http-equiv="x-ua-compatible" content="IE=edge" >
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<?php wp_head();?>
</head>

<body <?php body_class() ;?>>
	<div id="anony-hidden-search-form">
		<a class="anony-search-form-toggle" href="#" title="Scroll page"><i class="fa fa-search"></i></a>
			<?php get_search_form() ?>
	</div>
	<div id="anony-grid-wrapper">
		<div class="anony-grid">
			 <div class="anony-grid-col-">
					<header>
						<?php get_template_part('templates/top-header') ;?>
						
						<div id="anony-sub-top-wrapper">
						
							<div id="anony-toggles-wrapper">
								<a href="#" id="anony-menu-toggle"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></a>
								<a class="anony-search-form-toggle" href="#"><i class="fa fa-search"></i></a>
							</div>

							 <?php echo anony_get_custom_logo('orange') ;?>

							 <?php if(has_action('header_ad')){?>
								 <div id="anony-ads" class="anony-grid-col-md-6 anony-grid-col-sm-6">

									<?php do_action('header_ad'); ?>

								 </div>
							<?php  }

								 if(function_exists('anony_user_main')){
									 
									echo '<div class="anony-grid-col-md-3 anony-grid-col-sm-3">';

									 //User control plugin's menu
									 echo anony_user_main('user-control');

									echo '</div>';	
								 }

							?>

						</div>
						<?php echo anony_navigation('main-menu') ?>
					</header>
			</div>
		</div>