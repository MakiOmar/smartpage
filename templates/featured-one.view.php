<div id="anony-slider-wrapper" class="white-bg anony-full-height">
	<?php if ( $message !== '' ) : ?>
		 
		<p><i class="fa fa-frown-o fa-4x"></i></p>
		<p class="anony-warning"><?php echo $message; ?></p>
		 
	<?php endif ?>
	 
	<?php if ( $data !== array() ) : ?>    
		 
		<div id="anony-featured" class="anony-full-height" data-slider='<?php echo json_encode( $slider_data ); ?>'>
		 
			<div id="anony-active-slide" class="anony-full-height">
		<?php
		foreach ( $data as $index => $p ) :
			extract( $p );
			?>

						<div id="anony-item-<?php echo $id; ?>" class="anony-view anony-full-height">

			<?php echo  get_the_post_thumbnail( $id, 'full' ); ?>

							  <div class="anony-title-readmore">

								  <h2 class="anony-slide-title">
									  <a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
								  </h2>
			<?php if ( $show_read_more ) : ?>
								   
									  <a class="anony-featured-button" href="<?php echo $permalink; ?>"><?php echo $read_more; ?></a>
								   
			<?php endif; ?>
							  </div>
							</div>
		<?php endforeach ?>
				</div>
			<div class="anony-skew-bg">
			<h3 class="anony-featured-posts-title">
	 
				<a href="<?php echo $title_link; ?>"><?php echo $title_text; ?></a>

			</h3>
			</div>
			 
		<?php if ( $show_pagination ) : ?>
				<div id="anony-slides-list">

			<?php
			foreach ( $slider_nav as $item ) :
				extract( $item );
				?>
						 
				<?php if ( $pagination_type == 'thumbnails' ) : ?>

							<a href="<?php echo $permalink; ?>" data-id="anony-item-<?php echo $id; ?>" class="<?php echo $class; ?>anony-slide-item">

								<img class="anony-slide-thumb" src="<?php echo  get_the_post_thumbnail_url( $id, 'thumbnail' ); ?>" alt="<?php echo $title_attr; ?>"/>

							</a>
						<?php else : ?>
							<div data-id="anony-item-<?php echo $id; ?>" class="<?php echo $class; ?>anony-slide-item anony-pagination-dot"></div>
						<?php endif ?>
			<?php endforeach ?>

				</div>
		<?php endif ?>
		</div>
	 
	<?php endif ?>
</div>
