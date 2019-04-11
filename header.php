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
<div id="hidden-search-form">
	<a class="search-form-toggle" href="#" title="Scroll page"><i class="fa fa-search"></i></a>
		<?php get_search_form() ?>
</div>
<div id="grid-wrapper">
<div class="grid">
	 <div class="grid-col-">
			<header>
				<?php get_template_part('templates/temp','top-header') ;?>	
				<div id="sub-top-wrapper">
                <div id="toggles-wrapper">
                	<a href="#" id="menu-toggle"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></a>
                 	<a class="search-form-toggle" href="#"><i class="fa fa-search"></i></a>
                </div>
				 <?php echo smartpage_custom_logo('orange') ;?>
				 <div id="ads" class="grid-col-md-6 grid-col-sm-6">
				 <?php
					 $SmpgOptions = Smpg_Options::get_instance();
					 
					 $smpgAD = $SmpgOptions->get_option('smpg_ad');
					 
					 if($smpgAD && !empty($smpgAD)){
						 
						 echo $smpgAD;
						 
					 }else{?>
					 
						 <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- Responsive Prosentra --><ins class="adsbygoogle"style="display:block"data-ad-client="ca-pub-3107909375387230"data-ad-slot="8162895901"data-ad-format="auto"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
						 
						 <!--<img alt="" src="<?php /*echo get_theme_file_uri();*/?>/images/banner.png"/>-->
						 
					<?php }?>
				 	
				 </div>
				 
				 	<?php 
					 if(function_exists('smpg_user_main')){
						echo '<div class="grid-col-md-3 grid-col-sm-3">';
						 //User control plugin's menu
						 echo smpg_user_main('user-control');
						echo '</div>';	
					 }
						 
					 ?>
				
				</div>
				<?php echo smpg_main_navigation('main-menu') ?>
			</header>
	</div>
</div>