<?php get_header();?>
  <div class="grid">
  	<div class="grid-row grid-col">
       <?php get_sidebar('single');?>
        <div class="grid-col grid-col-sm-7">
        
        <?php smpg_breadcrumbs()?>
        
        <div class="post-title-image">
			<div class="post-title-cover"></div>
			<?php if(has_post_thumbnail()) the_post_thumbnail('full') ?>
			<h1 class="single_post_title"><a href="<?php echo get_the_permalink() ;?>"><?php echo get_the_title() ?></a></h1>
		</div>
		
		 <div class="post_meta meta">
			<div class="date">
				<i class="fa fa-calendar"></i>
				<span class="single-meta-text"><?php echo get_the_date() ?></span>
			</div>
			
			<div class="comments">
				<i class="fa fa-comments-o"></i>
				<?php echo smpg_comments_number(); ?>
			</div>
			
			<div class="category">
				<i class="fa fa-folder-open"></i>
				<a class="single-meta-text" href="<?php echo get_category_link(get_the_category()[0]->cat_ID);?>"><?php echo get_the_category()[0]->name ;?></a>
			</div>
			
			<?php get_template_part('templates/temp','rate') ?>
			
		  </div>
				<?php 
					if ( have_posts() ) {
					while (have_posts() ) { the_post();?>
					<div class="grid-col post-contents single_post">
					  <div class="post-info">
						  <div class="single-text">
        					<?php the_content();?>
							</div>
						</div>

					  </div>
				  <?php }}
				comments_template( '', true ); ?>
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>