<?php

$anonyOptions = anony_opts_();

if($anonyOptions->sidebar == 'left-sidebar'){
	get_sidebar();
}elseif($anonyOptions->single_sidebar == '1'){
	get_sidebar('single');
}

?>

<?php 
	if(has_action('post_ad')){
		do_action('post_ad');
	}
?>
<div class="anony-grid-col <?php echo ($anonyOptions->single_sidebar == '1') ? 'anony-grid-col-sm-7' : 'anony-grid-col-sm-9-5' ?>">

<?php anony_breadcrumbs()?>

<div class="anony-post-title-image">
	<div class="anony-post-title-cover"></div>
	<?php if(has_post_thumbnail()) the_post_thumbnail('full') ?>
	<h1 class="anony-single_post_title"><a href="<?php echo get_the_permalink() ;?>"><?php echo get_the_title() ?></a></h1>
</div>

 <div class="anony-post_meta meta">
	<div class="date">
		<i class="fa fa-calendar"></i>
		<span class="single-meta-text"><?php echo get_the_date() ?></span>
	</div>
	
	<div class="anony-comments">
		<i class="fa fa-comments-o"></i>
		<?php echo anony_comments_number(); ?>
	</div>
	
	<?php 
	$categories = get_the_category();
	if(is_array($categories) && !empty($categories)) {?>
	<div class="category">
		<i class="fa fa-folder-open"></i>
		<a class="single-meta-text" href="<?php echo get_category_link($categories[0]->cat_ID);?>"><?php echo $categories[0]->name ;?></a>
	</div>
	
	<?php } ?>
	
	<?php get_template_part('templates/rate') ?>
	
  </div>
		<?php 
			if ( have_posts() ) {
			while (have_posts() ) { the_post();?>
			<div class="anony-grid-col anony-post-contents anony-single_post">
			  <div class="anony-post-info">
				  <div class="anony-single-text">
					<?php the_content();?>
					</div>
				</div>

			  </div>
		  <?php }}
		comments_template( '', true ); ?>
</div>
<?php

if($anonyOptions->sidebar == 'right-sidebar'){
	get_sidebar();
}elseif($anonyOptions->single_sidebar == '1'){
	get_sidebar('single');
}

?>