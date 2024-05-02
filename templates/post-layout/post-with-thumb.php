<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}
?>
<div class="anony-post-image-wrapper">
	<div class="anony-toggle-excerpt" rel-id="anony-text-<?php echo $id; ?>"><i class="fa fa-arrow-up"></i></div>
	 
	<div class="anony-text" id="anony-text-<?php echo $id; ?>">
		<h3 class="anony-thumb-post-title" id="anony-text-<?php echo $id; ?>-title">
			<a href="<?php echo $permalink; ?>"><?php echo $title; ?></a>
		</h3>
		<p class="anony-hidden-paragraph"><?php echo $excerpt; ?></p>
	</div>
	 
	<div class="anony-post_meta anony-inside-thumb">
		<div class="date">
		<i class="fa fa-calendar meta-text"></i>
		<span class="meta-text"><?php echo $date; ?></span>
		</div>
		<div class="anony-comments">
			<i class="fa fa-comments-o meta-text"></i> <?php echo $comments_number; ?>
		</div>
	</div>
	   
	<?php if ( $has_category ) : ?>

		<h4>
			<a href="<?php echo $_1st_category_url; ?>"><?php echo $_1st_category_name; ?></a>
		</h4>
		 
	<?php endif ?>

	<div class="anony-shares-count">
		<i class="fa fa-share-alt"></i>
		<span>
		<?php
		// Translators: Number of shares.
		printf( esc_html__( '%s Shares', 'smartpage' ), esc_html( wp_rand( 200, 1000 ) ) );
		?>
		</span>
	</div>
	   
	<div class="anony-post-title-cover">
		<a href="<?php echo $permalink; ?>" title="<?php echo $title_attr; ?>">.</a>    
		</div>
		
		<div class="anony-thumb">
			<?php echo get_the_post_thumbnail( $id, 'full' ); ?>
		</div>
	 
</div>
