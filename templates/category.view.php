<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();?>

<div class="anony-grid">
	<div class="anony-grid-col anony-grid-row">
		<div class="anony-grid-col-sm-9-5 anony-grid-col">
		<?php
		if ( ! empty( $sub_categories ) ) :
			?>

			<div class="anony-container">

				<h3 class="anony-cat-section-title">

			<?php echo '--- ' . $cat_name . ' / ' . $page_title . ' ---'; ?>

				<div id="anony-ca-container" class="anony-ca-container">
					<div class="anony-ca-wrapper">
			<?php

			foreach ( $sc_view_data as $sc ) :

				extract( $sc );
				?>
							<div class="anony-ca-item anony-ca-item-<?php echo $sc_id; ?> anony-grid-col-md-4 anony-grid-col-av-6">
								<div class="anony-ca-item-main">

									<div class="anony-ca-icon">
										<i class="fa fa-folder-open fa-4x"></i>
									</div>

									<h3 class="anony-ca-item-title">

				<?php echo $sc_name; ?>
											 
									</h3>

				<?php if ( ! empty( $sc_desc ) ) : ?>

										<h4>
											<span class="anony-ca-quote">
					<?php echo $sc_quote; ?>
											</span>

											<span><?php echo $sc_desc; ?></span>
										</h4>

				<?php endif ?>

									<a href="<?php echo $sc_link; ?>" class="anony-cat-more"><?php echo $sc_link_text; ?></a>
								</div>
							</div>
			<?php endforeach ?>
					   </div>
				</div>
			</div>
 
			<?php
		endif;

		if ( $posts ) :
			?>
			<h3 class="anony-cat-section-title">
			<?php echo '--- ' . $cat_name . ' / ' . $page_title . ' ---'; ?>
			</h3>
			<div id="anony-<?php echo $grid; ?>">

				<div id="anony-blog-post">

			<?php
			foreach ( $posts as $post_data ) :
				extract( $post_data );

				include locate_template( 'templates/blog-post.view.php', false, false );

			endforeach;
			?>
				</div>
				 
				 
			</div>
			 
			<?php echo $pagination; ?>
			 
			<?php
			else :
				echo ANONY_NODATA;

			endif;
			?>
		 
		</div>

	   <?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>
