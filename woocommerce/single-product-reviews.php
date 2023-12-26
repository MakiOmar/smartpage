<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div id="anony-reviews-details">

			
		<div class="anony-grid-row">
			<div class="anony-grid-col anony-grid-col-max-480-12 anony-grid-col-sm-3">
				<h3 id="anony-average-rating">
					<?php
					//phpcs:disable
					echo $product->get_average_rating();
					//phpcs:enable.
					?>
				</h3>
				<?php
				if ( 0 === $product->get_average_rating() ) {
					?>

						<h2><?php esc_html_e( 'No Rating yet', 'smartpage' ); ?></h2>

					<?php
				} else {

					woocommerce_template_single_rating();
				}

				?>
			</div>
			<div class="anony-grid-col anony-grid-col-max-480-12 anony-grid-col-sm-6">
				<?php
					$total_count = $product->get_rating_count();
					$counts      = $product->get_rating_counts();

				for ( $i = 5; $i >= 1; $i-- ) {
					if ( isset( $counts [ $i ] ) ) {
						$width = ( $counts [ $i ] / $total_count ) * 100;
					} else {
						$width = 0;
					}


					?>
						<div class="review-rating-bars">
							<span class="review-rating-bg">
								<span class="review-rating-fg" style="width: <?php echo esc_attr( $width ); ?>%"></span>
							</span>
							<span class="review-rating-value">
								<?php
								// Translators: Rating value.
								printf( esc_html( _nx( '%1$s Star', '%1$s Stars', $i, 'Stars rating title', 'smartpage' ), $i ) );
								?>
							</span>

						</div>
					<?php
				}


				?>
			</div>

			<div class="anony-grid-col anony-grid-col-max-480-12 anony-grid-col-sm-3">
				<h2><?php esc_html_e( 'Rate this product', 'smartpage' ); ?></h2>
				<h4><?php esc_html_e( 'Rating help others to make choices', 'smartpage' ); ?></h4>
				<a id='go-add-review'  href="#review_form_wrapper"><?php esc_html_e( 'Add a review', 'smartpage' ); ?></a>
			</div>
		</div>
			
		
		
	</div>
	
	<div id="comments">
		
			<h2 class="woocommerce-Reviews-title">
				<?php
				$count = $product->get_review_count();
				if ( $count && wc_review_ratings_enabled() ) {
					/* translators: 1: reviews count 2: product name */
					$reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
					//phpcs:disable
					echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
					//phpcs:enable.
				}
				?>
			</h2>
			
		
		<?php if ( have_comments() ) : ?>
			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				$anony_options = ANONY_Options_Model::get_instance();
				if ( '1' === $anony_options->enable_woo_comments_load_more ) {
					$load_more = __( 'Load more', 'smartpage' );
					?>
					<div class="anony-grid-row flex-h-center"><a class="button anony-button load-more-comments" href="#" title="<?php echo esc_attr( $load_more ); ?>"><?php echo esc_html( $load_more ); ?></a></div>
					<style>
						.woocommerce-pagination{
							display: none;
						}
					</style>
					<?php
				}
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
							'next_text' => is_rtl() ? '&larr;' : '&rarr;',
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					/* translators: %s is product title */
					'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'woocommerce' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
					/* translators: %s is product title */
					'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'woocommerce' ),
					'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
					'title_reply_after'   => '</span>',
					'comment_notes_after' => '',
					'label_submit'        => esc_html__( 'Submit', 'woocommerce' ),
					'logged_in_as'        => '',
					'comment_field'       => '',
				);

				$name_email_required = (bool) get_option( 'require_name_email', 1 );
				$fields              = array(
					'author' => array(
						'label'    => __( 'Name', 'woocommerce' ),
						'type'     => 'text',
						'value'    => $commenter['comment_author'],
						'required' => $name_email_required,
					),
					'email'  => array(
						'label'    => __( 'Email', 'woocommerce' ),
						'type'     => 'email',
						'value'    => $commenter['comment_author_email'],
						'required' => $name_email_required,
					),
				);

				$comment_form['fields'] = array();

				foreach ( $fields as $key => $field ) {
					$field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';
					$field_html .= '<label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] );

					if ( $field['required'] ) {
						$field_html .= '&nbsp;<span class="required">*</span>';
					}

					$field_html .= '</label><input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $field['required'] ? 'required' : '' ) . ' /></p>';

					$comment_form['fields'][ $key ] = $field_html;
				}

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'woocommerce' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
				}

				if ( wc_review_ratings_enabled() ) {
					$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'woocommerce' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'woocommerce' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'woocommerce' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'woocommerce' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'woocommerce' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'woocommerce' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'woocommerce' ) . '</option>
					</select></div>';
				}

				$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'woocommerce' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>
	<?php endif; ?>

	<div class="clear"></div>
</div>
