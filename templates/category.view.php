<?php get_header( );?>

<div class="anony-grid">
	<div class="anony-grid-col anony-grid-row">
    	<div class="anony-grid-col-sm-9-5 anony-grid-col">
        <?php 
        if(!empty($sub_categories)) :	?>

			<div class="anony-container">

				<h3 class="anony-cat-section-title">

					<?= '--- '.$cat_name.' / '.$page_title.' ---'?>

				</h3> <a href="#" class="anony-share-email-popup">click</a>

				<div id="anony-ca-container" class="anony-ca-container">
					<div class="anony-ca-wrapper">
						<?php 

						foreach ($sc_view_data as $sc) :

							extract($sc);
							?>
							<div class="anony-ca-item anony-ca-item-<?= $sc_id ?> anony-grid-col-md-4 anony-grid-col-av-6">
								<div class="anony-ca-item-main">

									<div class="anony-ca-icon">
										<i class="fa fa-folder-open fa-4x"></i>
									</div>

									<h3 class="anony-ca-item-title">

										<?= $sc_name ;?>
											
									</h3>

									<?php if(!empty($sc_desc)): ?>

										<h4>
											<span class="anony-ca-quote">
												<?= $sc_quote?>
											</span>

											<span><?= $sc_desc ?></span>
										</h4>

									<?php endif ?>

									<a href="<?= $sc_link ?>" class="anony-cat-more"><?= $sc_link_text ?></a>
								</div>
							</div>
						<?php endforeach ?>
       				</div>
				</div>
			</div>
 
		<?php endif;

		if ( $have_posts ) :?>
			<h3 class="anony-cat-section-title">
				<?= '--- '.$cat_name.' / '.$page_title.' ---'?>
			</h3>

			<?php 


			foreach ($posts as $post_data ) :
				extract($post_data);

				include wp_normalize_path( STYLESHEETPATH. '/templates/blog-post.php' );

			endforeach;
		endif;
	?>
	    </div>

	   <?php get_sidebar();?>

	</div>
</div>

<?php get_footer();?>