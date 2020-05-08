<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div class="anony-section<?= $sec_class  ?>">
	<div class="anony-skew-bg">
		<h4 class="anony-section_title clearfix"><?= $sec_title ?></h4>
	</div>
	
	<div class="anony-posts-wrapper">

		<div id="anony-download">

			<?php foreach ($data as $p) : extract($p);?>

				<div id="download-<?= $id ?>" class="download-wrapper anony-grid-col-max-480-6 anony-grid-col-av-4 grid-10-col-md-2">

					<div class="anony-grid-col anony-post-contents">

						<div class="anony-download-meta">

							<div class="anony-hover-toggle anony-post-image-wrapper" style="background-color: transparent">

								<div id="download-<?= $id?>-count" class="anony-download-counter"><span><?= $download_times ?></span><br><?= $downloads_text ?></div>

								<div class="anony-box-shadow anony-download-thumb">
									<?php if( $thumb && $thumb_exists ) : ?>
								
										<?= $thumb_img ?>

									<?php else :?>

									<a href="<?= $permalink ?>" title="<?= $title ?>"><img src="<?= $default_thumb ?>" alt="<?= $title ?>"/></a>

									<?php endif ?>

								</div>
							</div>

						</div>

						<h4 class="download-title"><?= $title ?></h4>

						<div class="download">

							<a title="download-<?= $id?>" target="_blank" class="anony-download" href="<?= $file_url ?>" rel-id="<?= $id?>" download><i class="fa fa-download"></i></a>
						</div>

					</div>

				</div>

			<?php endforeach ?>

		</div>
	</div>
</div>