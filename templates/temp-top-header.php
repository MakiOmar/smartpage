<?php 
$socials_follow = array(
				'facebook' => '#',
				'twitter' => '#',
				'google-plus' => '#',
				'youtube' => '#',
				'pinterest' => '#',
				'instagram' => '#',
				'tumblr' => '#',
				'rss' => '#',
				);
?>
<div id="top-header-wrapper">
	<nav id="follow-contact">
	  <ul id="follow">
	  	<?php foreach($socials_follow as $social_follow => $url){
	$link_title = esc_html__(sprintf('Follow with %s' , ucfirst($social_follow)),TEXTDOM);
				echo '<li><a class="icon" href="'.$url.'" title="'.$link_title.'" target="_blank"><i class="fa fa-'.$social_follow.'"></i></a></li>';
		} ?>
		<li><a href="tel:00966536539253" class="phone-call"><i class="fa fa-phone"></i></a></li>
		<li><a href="mailto:mo7amed.maki@gmail.com" class="email-me"><i class="fa fa-envelope"></i></a></li>
	  </ul>
	  <?php echo smpg_main_navigation('languages-menu','') ?>
	</nav>
</div>