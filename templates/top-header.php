<?php
$anonyOptions = anony_opts_();

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
	  <ul id="anony-follow">
		<?php 
			foreach($socials_follow as $social_follow => $url){
				
				$link_title = esc_html__(sprintf('Follow on %s' , ucfirst($social_follow)),TEXTDOM);
				
				echo '<li><a class="icon" href="'.$url.'" title="'.$link_title.'" target="_blank"><i class="fa fa-'.$social_follow.'"></i></a></li>';
				
			} 
		?>
		<li><a href="tel:<?php echo $anonyOptions->phone ?>" class="phone-call"><i class="fa fa-phone"></i></a></li>
		
		<li><a href="mailto:<?php echo $anonyOptions->email ?>" class="email-me"><i class="fa fa-envelope"></i></a></li>
		
		<a href="<?php echo wp_logout_url(); ?>">Logout</a>
		
	  </ul>
	  <?php echo anony_main_navigation('languages-menu','') ?>
	</nav>
</div>