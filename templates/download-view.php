<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
wp_enqueue_script( 'anony-download' );
?>
<div class="anony-section<?php echo $sec_class; ?> white-bg">
	<div class="anony-skew-bg">
		<h4 class="anony-section_title"><?php echo $sec_title; ?></h4>
	</div>
	 
	<div class="anony-posts-wrapper">

		<div id="anony-download">

			<?php
			foreach ( $data as $p ) :
				extract( $p );
				?>

				<div id="download-<?php echo $id; ?>" class="download-wrapper anony-grid-col-max-480-6 anony-grid-col-av-4 grid-10-col-md-2">

					<div class="anony-grid-col anony-post-contents">

						<div class="anony-download-meta">

							<div class="anony-hover-toggle anony-post-image-wrapper" style="background-color: transparent">

								<div id="download-<?php echo $id; ?>-count" class="anony-download-counter"><span><?php echo $download_times; ?></span><br><?php echo $downloads_text; ?></div>

								<div class="anony-box-shadow anony-download-thumb">
									<?php if ( $thumb && $thumb_exists ) : ?>
								 
										<?php echo get_the_post_thumbnail( $id, 'download-thumb' ); ?>

									<?php else : ?>

									<a href="<?php echo $permalink; ?>" title="<?php echo $title; ?>"><img src="<?php echo $default_thumb; ?>" alt="<?php echo $title; ?>"/></a>

									<?php endif ?>

								</div>
							</div>

						</div>

						<h4 class="download-title"><?php echo $title; ?></h4>

						<div class="download">

							<a title="download-<?php echo $id; ?>" target="_blank" class="anony-download" href="<?php echo $file_url; ?>" rel-id="<?php echo $id; ?>" download><i class="fa fa-download"></i></a>
						</div>

					</div>

				</div>

			<?php endforeach ?>

		</div>
	</div>
</div>
