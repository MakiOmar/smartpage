<?php
$smpgOptions = opt_init_();

$socials_follow = array(
				'facebook' => $smpgOptions->facebook,
				'twitter' => $smpgOptions->twitter,
				'youtube' => $smpgOptions->youtube,
				'pinterest' => $smpgOptions->pinterest,
				'linkedin' => $smpgOptions->linkedin,
				'instagram' => $smpgOptions->instagram,
				'tumblr' => $smpgOptions->tumblr,
				'rss' => $smpgOptions->rss,
				);
?>
<div id="top-header-wrapper">
	<nav id="follow-contact">
	  <ul id="follow">
		<?php 
			foreach($socials_follow as $social_follow => $url){
				
				$link_title = esc_html__(sprintf('Follow on %s' , ucfirst($social_follow)),TEXTDOM);
				
				echo '<li><a class="icon" href="'.$url.'" title="'.$link_title.'" target="_blank"><i class="fa fa-'.$social_follow.'"></i></a></li>';
				
			} 
		?>
		<li><a href="tel:<?php echo $smpgOptions->phone ?>" class="phone-call"><i class="fa fa-phone"></i></a></li>
		
		<li><a href="mailto:<?php echo $smpgOptions->email ?>" class="email-me"><i class="fa fa-envelope"></i></a></li>
		
		<a href="<?php echo wp_logout_url(); ?>">Logout</a>
		
	  </ul>
	  <?php echo anony_main_navigation('languages-menu','') ?>
	</nav>
</div>