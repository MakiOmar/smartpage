<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}

get_header();

?>

<div class="anony-grid">
	<div class="anony-grid-row anony-grid-col">
		 
		<?php

		anony_breadcrumbs();

		get_sidebar( 'right-sidebar' );

		$pID = $id;

		if ( has_action( 'post_ad' ) ) {
			do_action( 'post_ad' );
		}

		?>
		 
		<div class="anony-grid-col <?php echo $wrapper_class; ?>">
						 
			<?php if ( $thumb && $thumb_exists ) : ?>

				<div class="anony-post-title-image">
					 
					<div class="anony-post-title-cover"></div>
					 
				<?php echo $thumb_img_full; ?>
					 
					<h1 class="anony-single_post_title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h1>
				</div>

			<?php else : ?>

				<h1 class="anony-single_post_title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h1>    
			 
			<?php endif ?>

			<div class="anony-post_meta meta white-bg">
				<div class="date">
					<i class="fa fa-calendar"></i>
					<span class="single-meta-text"><?php echo $date; ?></span>
				</div>
				 
				<div class="anony-comments">
					<i class="fa fa-comments-o"></i>
					<?php echo $comments_number; ?>
				</div>
				 
				<?php

				if ( $has_category ) :
					?>
					<div class="category">
						<i class="fa fa-folder-open"></i>
						 
					<?php
					foreach ( $categories as $category ) :

						$category = (array) $category;

						extract( $category );

						$link = get_category_link( $cat_ID );
						?>
							 
							<a class="single-meta-text" href="<?php echo $link; ?>"><?php echo $name; ?></a>
							 
					<?php endforeach ?>
						 
					</div>
				 
				<?php endif ?>
				 
				<?php require locate_template( 'models/rate.php', false, false ); ?>
				 
			</div>

			<div class="anony-grid-col anony-post-contents anony-single_post">
				 
				<div class="anony-post-info">
					 
				  <div class="anony-single-text white-bg"><?php echo $content; ?></div>
				   
				</div>

			</div>

			<?php
			if ( $comments_open ) {
				comments_template( '', false );
			}
			?>
			 
			<div class="anony-ad">
						 
				<?php do_action( 'before_footer_ad' ); ?>
						 
			</div>
			 
		</div>
		 
		<?php get_sidebar( 'left-sidebar' ); ?>
		 
	</div>
	 
</div>


<?php get_footer(); ?>
