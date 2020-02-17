<?php
global $anonyOptions;

$socials_follow = array(
				'facebook' => $anonyOptions->facebook,
				'twitter' => $anonyOptions->twitter,
				'youtube' => $anonyOptions->youtube,
				'pinterest' => $anonyOptions->pinterest,
				'linkedin' => $anonyOptions->linkedin,
				'instagram' => $anonyOptions->instagram,
				'tumblr' => $anonyOptions->tumblr,
				'rss' => $anonyOptions->rss,
				);
?>
<div id="anony-top-header-wrapper">
	<nav id="anony-follow-contact">

		 <?php
			/** 
			 * The ANONY_MENU constant is defined in User control plugin.
			 * It contains user menu slug, defined by the plugin
			 */
		 	if(defined('ANONY_MENU') && wp_get_nav_menu_object( ANONY_MENU )){
		 		echo wp_nav_menu(['menu' => ANONY_MENU , 'fallback_cb' => false]);
		 	}else{
		 		echo anony_navigation('anony-user-menu');
		 	}
		 ?>

	  <ul id="anony-follow">
		<?php 
			foreach($socials_follow as $social_follow => $url){
				
				$link_title = esc_html__(sprintf('Follow on %s' , ucfirst($social_follow)),ANONY_TEXTDOM);
				
				echo '<li><a class="icon" href="'.$url.'" title="'.$link_title.'" target="_blank"><i class="fa fa-'.$social_follow.'"></i></a></li>';
				
			} 
		?>
		<li><a href="tel:<?php echo $anonyOptions->phone ?>" class="phone-call"><i class="fa fa-phone"></i></a></li>
		
		<li><a href="mailto:<?php echo $anonyOptions->email ?>" class="email-me"><i class="fa fa-envelope"></i></a></li>
		
	  </ul>

	  <?php echo anony_navigation('languages-menu','') ?>
	</nav>
</div>