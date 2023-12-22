<?php
/**
 * Term listing
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="anony-grid-row flex-h-center">
	<?php
	while ( $query->have_posts() ) {
		$query->the_post();
		$data = anony_common_post_data( $atts['post_type'] );
		?>
			<div class="anony-grid-col anony-grid-col-sm-<?php echo esc_attr( $desktop_columns ); ?> anony-grid-col-slg-<?php echo esc_attr( $mobile_columns ); ?>">
				<div class="anony-posts-listing anony-<?php echo esc_attr( $atts['post_type'] ); ?>-listing ">
					<?php
					$thumb_url = get_the_post_thumbnail_url( $data['id'], $thumb_size );
					?>
					<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php the_title_attribute(); ?>"/>
					<div class="anony-posts-listing-content">
						<div class="anony-post_meta">
							<div class="date">
								<i class="fa fa-calendar meta-text"></i>
								<span class="meta-text"><?php echo esc_html( $data['date'] ); ?></span>
							</div>
							
							<div class="anony-comments">
								<i class="fa fa-comments-o meta-text"></i>
								<?php echo wp_kses_post( $data['comments_number'] ); ?>
							</div>

							<?php if ( $data['has_category'] ) { ?>
							
								<div class="category">
								
									<i class="fa fa-folder-open meta-text"></i>
									
									<a class="meta-text" href="<?php echo esc_url( $data['_1st_category_url'] ); ?>"><?php echo esc_html( $data['_1st_category_name'] ); ?></a>
								
								</div>
							
							<?php } ?>
							
						</div>
						<h1><?php echo esc_html( $data['title'] ); ?></h1>
						<p><?php echo wp_kses_post( $excerpt ); ?></p>

						<a class="button anony-button" href="<?php echo esc_url( $data['permalink'] ); ?>"><?php echo esc_html( $data['read_more'] ); ?></a>
					</div>
				</div>
			</div>
		<?php
	}
	?>
</div>
