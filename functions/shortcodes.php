<?php
/**
 * Adding shortcodes
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Array of shortcodes to be added.
$shcods = array(
	'anony_ltrtext',
	'anony_products_loop',
	'anony_section_title',
	'anony_banner',
	'anony_row',
	'anony_column',
	'anony_shape_divider',
	'anony_divider',
	'anony_posts_slider',
	'anony_images_slider',
	'anony_content_slider',
	'anony_testimonials',
	'anony_faqs',
	'anony_terms_listing',
	'anony_post_listing',
	'anony_popup',
	'anony_navigation',
	'anony_price_tables',
	'anony_fancy_list',
	'anony_get_block',
	'anony_spacer',
	'anony_timeline',
	'anony_svg_icon',
	'anony_block',
	'anony_image',
	'anony_device_content',
	'anony_phone_input',
);

foreach ( $shcods as $code ) {
	add_shortcode( $code, $code . '_shcode' );
}

/**
 * Renders phone input
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_phone_input_shcode( $atts ) {
	$atts       = shortcode_atts(
		array(
			'name'        => 'phone',
			'with-styles' => 'yes',
			'target'      => '',
		),
		$atts,
		'phone_input'
	);
	$countries  = file_get_contents( 'https://jalsah.app/wp-content/uploads/2024/09/countires-codes-and-flags.json' );
	$countries  = json_decode( $countries, true );
	$key_values = array_column( $countries, 'name_ar' );
	array_multisort( $key_values, SORT_ASC, $countries );
	$user_country_code = snsk_ip_api_country();
	$unique_id         = wp_unique_id( 'anony_' );
	ob_start();
	?>
	<?php if ( '' !== $atts['target'] ) { ?>
		<style>
			input[name=<?php echo esc_attr( $atts['target'] ); ?>]{
				display: none;
			}
		</style>
	<?php } ?>
	<?php if ( 'yes' === $atts['with-styles'] ) { ?>
	<style>
		.anony-dial-codes img.emoji {
			position: relative;
			top: 3px;
		}
		input.anony_dial_phone{
			margin-<?php echo is_rtl() ? 'right' : 'left'; ?>: 0;
		}
		.anony-dial-codes {
			position: relative;
			display: flex;
			direction: ltr;
			text-align: left;
			flex-grow: 1;
		}
		.anony-dial-codes-content {
			display: none;
			position: absolute;
			background-color: #f1f1f1;
			min-width: 160px;
			max-height: 200px;
			overflow-y: auto;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			z-index: 1;
			max-width: 250px;
				top: 55px;
		}
		.anony-dial-codes-content a {
			color: black;
			padding: 12px 16px;
			text-decoration: none;
			display: block;
		}
		.anony-dial-codes-content a:hover {
			background-color: #ddd;
		}
		.anony-filter-input {
			width: 100%;
			max-width: 220px;
			text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
			direction: <?php echo is_rtl() ? 'rtl' : 'ltr'; ?>;
			padding: 10px;
			box-sizing: border-box;
			margin-bottom: 5px;
		}
		button.anony_dial_codes_selected_choice{
			min-width:100px;
			height:47px;
			padding:0 10px;
			color: #000;
			background-color: #ddd;
		}
		.anony-dial-codes-phone-label{
			text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;;
			font-size: 18px;
		}
	</style>
	<?php } ?>
	<label class="anony-dial-codes-phone-label">رقم الموبايل</label>
	<div id="<?php echo esc_attr( $unique_id ); ?>" class="anony-dial-codes">
		<div class="anony-flex flex-v-center anony-full-width">
			<button class="anony_dial_codes_selected_choice"></button>
			<input type="tel" class="anony_dial_phone" name="<?php echo esc_attr( $atts['name'] ); ?>" value="<?php echo esc_attr( str_replace( $user_country_code, '', apply_filters( str_replace( '-', '_', $atts['name'] . '_value' ), '' ) ) ); ?>"/>
		</div>
		<!-- Filter Input Box -->
		<div class="anony-dial-codes-content">
		<input type="text" class="anony-filter-input" placeholder="إبحث عن الدولة...">
		<?php
		foreach ( $countries as $index => $country ) {
			$full_label = $country['flag'] . ' (<span style="direction="ltr"">' . $country['dial_code'] . '</span>) ' . $country['name_ar'];
			$label      = $country['flag'] . ' (' . $country['dial_code'] . ')';
			if ( $user_country_code === $country['country_code'] ) {
				$first_choice   = $label;
				$user_dial_code = $country['dial_code'];
			} elseif ( $index < 1 ) {
				$first_choice   = $label;
				$user_dial_code = $country['dial_code'];
			}
			echo '<span>';
			echo '<a class="anony-dialling-code" href="#" data-dial-code="' . esc_attr( $country['dial_code'] ) . '">' . wp_kses_post( $full_label ) . '</a>';
			echo '<a style="display:none" class="anony_selected_dial_code">' . wp_kses_post( $label ) . '</a>';
			echo '</span>';
		}
		?>
		</div>
		<input type="text" style="display:none" name="country_code" class="anony_dial_code" id="<?php echo esc_attr( $atts['name'] ); ?>_country_code" value="<?php echo isset( $user_dial_code ) ? esc_attr( $user_dial_code ) : ''; ?>"/>
		<div style="display:none" class="anony_dial_codes_first_choice"><?php echo isset( $first_choice ) ? wp_kses_post( $first_choice ) : ''; ?></div>
	</div>
	<?php
	add_action(
		'wp_footer',
		function () use( $atts, $unique_id ) {
			?>
			<?php if ( ! empty( $atts['target'] ) ) { ?>
				<script>
					jQuery( document ).ready( function( $ ) {
						$('input[name=<?php echo esc_attr( $atts['target'] ); ?>]').closest('.jet-form-builder-row').hide();
						var parent = $( '#<?php echo esc_attr( $unique_id ); ?>' );
						var phoneInput = $('input[name=<?php echo esc_attr( $atts['name'] ); ?>]', parent);
						var countryCodeInput = $('input[name=country_code]', parent);
			
						var target = '<?php echo esc_html( $atts['target'] ); ?>';
			
						function updateBillingPhone( billingPhoneInput ) {
							var phone = phoneInput.val().trim();
							var countryCode = countryCodeInput.val().trim();
							billingPhoneInput.val( countryCode + phone ).change();
						}
						if ( $('input[name=' + target + ']').val() === '' ) {
							// Set initial value on document ready
							updateBillingPhone( $('input[name=' + target + ']') );
						}
						phoneInput.on(
							'input',
							function(){
								updateBillingPhone( $('input[name=' + target + ']') );
							}
						);
						countryCodeInput.on(
							'input',
							function(){
								updateBillingPhone( $('input[name=' + target + ']') );
							}
						);
					} );
				</script>
			<?php } ?>
			<script>
				jQuery( document ).ready( function( $ ) {
					var parent = $( '#<?php echo esc_attr( $unique_id ); ?>' );
					$('.anony-filter-input', parent).on(
						'keyup',
						function () {
							const filter = $(this).val().toLowerCase();
							const links = $('.anony-dialling-code', parent);

							links.each(function () {
								const link = $(this);
								if (link.text().toLowerCase().includes(filter)) {
									link.parent().show();
								} else {
									link.parent().hide();
								}
							});

							// Show all links when the filter is empty
							if (!filter) {
								links.parent().show();
							}
						}
					);
				} );
				
			</script>
			<?php
		}
	);
	return ob_get_clean();
}

/**
 * Renders specific content for device
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_device_content_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'desktop-content' => '',
			'mobile-content'  => '',
		),
		$atts,
		'anony_image'
	);

	if ( empty( $atts['desktop-content'] ) && empty( $atts['mobile-content'] ) ) {
		return;
	}
	if ( wp_is_mobile() && ! empty( $atts['mobile-content'] ) ) {
		$_post = get_post( absint( $atts['mobile-content'] ) );
		if ( $_post ) {
			return apply_filters( 'the_content', $_post->post_content );
		}
	} elseif ( ! empty( $atts['desktop-content'] ) ) {
		$_post = get_post( absint( $atts['desktop-content'] ) );
		if ( $_post ) {
			return apply_filters( 'the_content', $_post->post_content );
		}
	}
}
/**
 * Renders a block
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_image_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id' => '',
		),
		$atts,
		'anony_image'
	);

	if ( empty( $atts['id'] ) ) {
		return;
	}
	return '';
}
/**
 * Renders a block
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_block_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id' => '',
		),
		$atts,
		'anony_block'
	);

	if ( empty( $atts['id'] ) ) {
		return;
	}
	$_post = get_post( absint( $atts['id'] ) );
	if ( $_post ) {
		return $_post->post_content;
	}
}

/**
 * Renders a timeline
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_svg_icon_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'name'          => '',
			'border-width'  => '1px',
			'border-radius' => '0',
			'border-color'  => '#000',
			'border-style'  => 'solid',
			'height'        => '100px',
			'width'         => '100px',
			'link'          => '',
			'link-bg'       => '#fff',
		),
		$atts,
		'anony_svg_icon'
	);

	if ( empty( $atts['name'] ) ) {
		return;
	}
	$border = $atts['border-width'] . ' ' . $atts['border-style'] . ' ' . $atts['border-color'];

	$icon = anony_option_svg_icon( $atts['name'] );
	if ( ! empty( $icon ) ) {
		$svg = '<span class="anony-icon anony-svg-icon" style="background-color:' . $atts['link-bg'] . ';display:flex;justify-content:center;align-items:center;margin:auto;border:' . $border . ';border-radius:' . $atts['border-radius'] . ';height:' . $atts['height'] . ';width:' . $atts['width'] . '">' . $icon . '</span>';
		if ( '' === $atts['link'] ) {
			return $svg;
		} else {
			return '<a class="anony-svg-icon-link" href="' . $atts['link'] . '">' . $svg . '</a>';
		}
	}
	return '';
}

/**
 * Renders a timeline
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_timeline_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id'                    => '',
			'line-color'            => '#000',
			'bullets-in-view-color' => '#777',
			'background-color'      => '#f3f3f3',
		),
		$atts,
		'anony_timeline'
	);

	if ( empty( $atts['id'] ) ) {
		return;
	}

	$line_color           = $atts['line-color'];
	$bullets_inview_color = $atts['bullets-in-view-color'];
	$backgrond_color      = $atts['background-color'];
	$id                   = absint( $atts['id'] );
	ob_start();
	require locate_template( 'templates/partials/timeline.php', false, false );
	return ob_get_clean();
}

/**
 * Renders a spacer
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_spacer_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'height' => '50px',
		),
		$atts,
		'anony_spacer'
	);
	return '<div style="width:100%;height:' . esc_attr( $atts['height'] ) . '"></div>';
}

/**
 * Renders a block
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_get_block_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id' => '',
		),
		$atts,
		'anony_get_block'
	);
	if ( ! empty( $atts['id'] ) ) {
		$_post = get_post( absint( $atts['id'] ) );
		if ( $_post ) {
			return '<div class="anony_get_block">' . $_post->post_content . '</div>';
		}
	}
	return '';
}
/**
 * Renders a fancy list
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_fancy_list_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'style'             => 'one',
			'target_class'      => 'wrapper',
			'item_width'        => '100%',
			'content_direction' => 'horizontal',
		),
		$atts,
		'anony_fancy_list'
	);

	$content_direction = 'vertical' === $atts['content_direction'] ? 'column' : 'row';
	ob_start();
	include locate_template( 'templates/partials/fancy-list/' . $atts['style'] . '.php', false, false );
	$styles = ob_get_clean();
	return str_replace( '___', $atts['target_class'], $styles );
}
/**
 * Renders price tables
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_price_tables_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids'    => '',
			'number' => 69,
		),
		$atts,
		'anony_price_tables'
	);

	$args = array(
		'post_type'      => 'anony_price_tables',
		'posts_per_page' => $atts['number'],
		'post_status'    => 'publish',
	);

	if ( ! empty( $atts['ids'] ) ) {
		$args['post__in'] = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
	}

	$query = new WP_Query( $args );

	$output = '';
	$data   = array();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$price_table_meta = get_post_meta( get_the_ID(), 'anony_price_table', true );
			if ( $price_table_meta && ! empty( $price_table_meta ) ) {
				$temp['id']               = get_the_ID();
				$temp['title']            = get_the_title();
				$temp['content']          = get_the_content();
				$temp['icon']             = get_the_post_thumbnail( get_the_ID(), 'full' );
				$temp['price']            = $price_table_meta['price'];
				$temp['title_bg_color']   = $price_table_meta['title_bg_color'];
				$temp['price_per']        = $price_table_meta['price_per'];
				$temp['subtitle']         = $price_table_meta['subtitle'];
				$temp['button_link']      = $price_table_meta['button_link'];
				$temp['button_text']      = $price_table_meta['button_text'];
				$temp['top_selling']      = $price_table_meta['top_selling'];
				$temp['top_selling_text'] = $price_table_meta['top_selling_text'];

				$data[] = $temp;
			}
		}
		wp_reset_postdata();
	}

	if ( ! empty( $data ) ) {
		ob_start();
		require locate_template( 'templates/partials/price-table.php', false, false );
		$output .= ob_get_clean();
	}

	return $output;
}

/**
 * Renders divider
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_divider_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'style'        => 'default',
			'thickness'    => '1px',
			'width'        => '100%',
			'color'        => '#000000',
			'border-style' => 'solid',
			'height'       => '20px',
			'align'        => 'center',
			'justify'      => 'flex-start',
		),
		$atts,
		'anony_divider'
	);

	return sprintf(
		'<div style="height:%2$s;display:flex;align-items:%6$s;justify-content:%7$s">
		<span style="display:block; border-bottom:%3$s %4$s %5$s;width:%1$s;"></span>
		</div>',
		$atts['width'],
		$atts['height'],
		$atts['thickness'],
		$atts['border-style'],
		$atts['color'],
		$atts['align'],
		$atts['justify']
	);
}

/**
 * Renders navigation menu by title
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_navigation_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'menu'     => '',
			'vertical' => 'yes',
			'divided'  => 'yes',
			'class'    => '',
			'align'    => 'center',
		),
		$atts,
		'anony_navigation'
	);

	$classes  = '';
	$classes .= 'yes' === $atts['vertical'] ? ' anony-vertical-menu' : ' anony-horizontal-menu';
	$classes .= 'yes' === $atts['divided'] ? ' anony-divided-menu' : '';
	$classes .= ! empty( $atts['class'] ) ? ' ' . $atts['class'] : '';
	if ( empty( $atts['menu'] ) ) {
		return;
	}
	$direction = is_rtl() ? 'to-left' : 'to-right';
	$menu_args = array(
		'menu'            => $atts['menu'],
		'container'       => 'nav',
		'container_class' => 'menu-container',
		'menu_class'      => "menu anony-menu {$direction}{$classes}",
		'echo'            => false,
		'items_wrap'      => '<ul id="%1$s" style="align-items:' . $atts['align'] . '" class="%2$s">%3$s</ul>',
	);
	return wp_nav_menu( $menu_args );
}

/**
 * Renders posts listings
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_post_listing_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'post_type'       => 'post',
			'ids'             => '',
			'number'          => 3,
			'desktop_columns' => 3,
			'mobile_columns'  => 1,
			'order'           => 'ASC',
		),
		$atts,
		'anony_post_listing'
	);

	$args = array(
		'post_type'      => $atts['post_type'],
		'posts_per_page' => $atts['number'],
		'post_status'    => 'publish',
	);

	if ( ! empty( $atts['ids'] ) ) {
		$args['post__in'] = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
	}
	$thumb_size      = wp_is_mobile() ? 'category-post-thumb-mobile' : 'category-post-thumb';
	$desktop_columns = 12 / absint( $atts['desktop_columns'] );
	$mobile_columns  = 12 / absint( $atts['mobile_columns'] );
	$output          = '';
	$query           = new WP_Query( $args );
	if ( $query->have_posts() ) {
		ob_start();
		require locate_template( 'templates/listings/post/post-listing-one.php', false, false );
		$output .= ob_get_clean();
	}
	return $output;
}

/**
 * Renders terms listings
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_terms_listing_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'taxonomy'          => 'category',
			'ids'               => '',
			'number'            => '',
			'desktop_columns'   => 4,
			'mobile_columns'    => 2,
			'image_id_meta_key' => 'thumbnail_id',
			'name_align'        => 'center',
			'desktop_font_size' => '18px',
			'mobile_font_size'  => '14px',
			'columns_base'      => 12,
			'show_title'        => 'no',
			'thumbnail_size'    => 'thumbnail',
			'height'            => '100px',
			'width'             => '100px',
			'layout'            => 'circle',
			'order'             => 'ASC',
			'orderby'           => 'id',
		),
		$atts,
		'anony_terms_listing'
	);

	$args = array(
		'taxonomy'   => $atts['taxonomy'],
		'number'     => $atts['number'],
		'fields'     => 'id=>name',
		'hide_empty' => false,
		'order'      => 'ASC',
		'orderby'    => 'id',
	);

	if ( isset( $atts['parent'] ) ) {
		$args['parent'] = absint( $atts['parent'] );
	}

	if ( ! empty( $atts['ids'] ) ) {
		$args['include'] = str_replace( ' ', '', $atts['ids'] );
	}

	$desktop_columns = absint( $atts['columns_base'] ) / absint( $atts['desktop_columns'] );
	$mobile_columns  = absint( $atts['columns_base'] ) / absint( $atts['mobile_columns'] );
	$name_align      = $atts['name_align'];
	$font_size       = wp_is_mobile() ? $atts['mobile_font_size'] : $atts['desktop_font_size'];
	$height          = $atts['height'];
	$width           = $atts['width'];
	$thumb_size      = $atts['thumbnail_size'];
	$show_title      = $atts['show_title'];
	$layout          = 'anony-' . $atts['layout'] . '-image';

	$image_id_meta_key = $atts['image_id_meta_key'];

	if ( '10' === $atts['columns_base'] ) {
		$class_prefix = 'anony-grid-10-col';
	} else {
		$class_prefix = 'anony-grid-col';
	}

	$output = '';
	$terms  = get_terms( $args );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		ob_start();
		require locate_template( 'templates/listings/term/term-listing-one.php', false, false );
		$output .= ob_get_clean();
	}
	return $output;
}

/**
 * Renders testimonials
 *
 * @param array $atts The shortcode attributes.
 * @return string
 */
function anony_testimonials_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id'              => '',
			'slider'          => 'off',
			'item-width'      => '320px',
			'height'          => 'auto',
			'per-page'        => '1',
			'style'           => 'default',
			'autoplay'        => 'no',
			'animation_speed' => '500',
		),
		$atts,
		'anony_testimonials'
	);
	$args = array(
		'post_type'      => 'anony_testimonial',
		'posts_per_page' => 5,
		'order'          => 'ASC',
	);

	$container_id = 'content-slider-' . uniqid();
	$item_width   = $atts['item-width'];
	$height       = $atts['height'];
	$slider_class = '';
	$output       = '';
	$query        = new WP_Query( $args );
	$data         = array();
	$style        = $atts['style'];
	if ( $query->have_posts() ) {
		$output .= '<div class="anony-testimonials anony-grid-row flex-h-center ' . $style . '">';
		while ( $query->have_posts() ) {
			$query->the_post();
			if ( 'off' === $atts['slider'] ) {
				ob_start();
				require locate_template( 'templates/testimonials.php', false, false );
				$output .= ob_get_clean();
			} else {
				$slider_class .= 'anony-content-slide ';
				ob_start();
				require locate_template( 'templates/testimonials.php', false, false );
				$temp['content'] = ob_get_clean();
				$data[]          = $temp;
			}
		}
		wp_reset_postdata();
		if ( ! empty( $data ) ) {
			if ( absint( $atts['per-page'] ) > count( $data ) ) {
				$per_page = count( $data );
			} else {
				$per_page = absint( $atts['per-page'] );
			}
			if ( wp_is_mobile() ) {
				$per_page = 1;
			}
			$slider_settings = array(
				'per_page'        => $per_page,
				'autoplay'        => $atts['autoplay'],
				'animation_speed' => $atts['animation_speed'],
			);
			ob_start();
			require locate_template( 'templates/partials/content-slider.php', false, false );
			$output .= ob_get_clean();
		}
		$output .= '</div>';
	}

	return $output;
}

/**
 * Flag to control scripts output
 *
 * @var string
 */
$GLOBALS['anony_popup_scripts'] = false;

/**
 * Flag to control styles output
 *
 * @var string
 */
$GLOBALS['anony_popup_styles'] = false;
/**
 * Renders popup
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_popup_shcode( $atts ) {
	global $anony_popup_scripts;
	$atts = shortcode_atts(
		array(
			'id'                  => '',
			'callback'            => '',
			'width'               => '200px',
			'height'              => '100vh',
			'padding'             => '0',
			'margin'              => '0',
			'border_width'        => '0',
			'border_style'        => 'solid',
			'border_color'        => '#000',
			'border_radius'       => '0',
			'background_color'    => '#fff',
			'zindex'              => '100',
			'animation_type'      => 'slide',
			'animation_direction' => 'right-left',
			'trigger_selector'    => '',
			'close-icon'          => 'x',
		),
		$atts,
		'anony_popup'
	);

	if ( empty( $atts['id'] ) && current_user_can( 'manage_options' ) ) {
		return esc_html__( 'Popup id is missing', 'smartpage' );
	}
	$content = '';
	if ( ! empty( $atts['callback'] ) ) {
		$content = call_user_func( $atts['callback'] );
	}
	$id               = $atts['id'];
	$width            = $atts['width'];
	$height           = $atts['height'];
	$border_width     = $atts['border_width'];
	$border_style     = $atts['border_style'];
	$border_color     = $atts['border_color'];
	$border_radius    = $atts['border_radius'];
	$background_color = $atts['background_color'];
	$zindex           = $atts['zindex'];
	$trigger_selector = $atts['trigger_selector'];
	$animation_type   = $atts['animation_type'];
	$close_icon       = apply_filters( 'anony_popup_close_icon', $atts['close-icon'] );
	$settings         = $atts;
	ob_start();
	require locate_template( 'templates/partials/popup.php', false, false );
	return ob_get_clean();
}

/**
 * Renders FAQs
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_faqs_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids'    => '',
			'number' => 3,
			'cat'    => false,
		),
		$atts,
		'anony_faqs'
	);

	$args = array(
		'post_type'      => 'anony_faqs',
		'posts_per_page' => $atts['number'],
		'post_status'    => 'publish',
	);

	if ( ! empty( $atts['ids'] ) ) {
		$args['post__in'] = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
	}

	if ( $atts['cat'] && ! empty( $atts['cat'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'anony_faqs_cats',
				'field'    => 'id',
				'terms'    => explode( ',', str_replace( ' ', '', $atts['cat'] ) ),
			),
		);
	}

	$query = new WP_Query( $args );

	$output = '';
	$data   = array();
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$temp['title']   = get_the_title();
			$temp['content'] = get_the_content();

			$data[] = $temp;
		}
		wp_reset_postdata();
	}

	if ( ! empty( $data ) ) {
		ob_start();
		require locate_template( 'templates/partials/accordion.php', false, false );
		$output .= ob_get_clean();
	}

	return $output;
}
if ( ! function_exists( 'anony_content_slider_shcode' ) ) {
	/**
	 * Renders content slider
	 *
	 * @param  string $atts the shortcode attributes.
	 * @return string
	 */
	function anony_content_slider_shcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'ids'             => '',
				'number'          => 3,
				'cat'             => false,
				'height'          => 'auto',
				'height-mobile'   => 'auto',
				'item-width'      => '100vw',
				'per-page'        => 1,
				'style'           => 'default',
				'autoplay'        => 'no',
				'animation_speed' => '500',
			),
			$atts,
			'anony_content_slider'
		);

		$item_width = $atts['item-width'];

		$slider_settings = array(
			'per_page'        => $atts['per-page'],
			'autoplay'        => $atts['autoplay'],
			'animation_speed' => $atts['animation_speed'],
		);

		$args = array(
			'post_type'      => 'anony_blocks',
			'posts_per_page' => $atts['number'],
			'post_status'    => 'publish',
		);

		if ( ! empty( $atts['ids'] ) ) {
			$args['post__in'] = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
		}

		if ( $atts['cat'] && ! empty( $atts['cat'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'anony_blocks_cats',
					'field'    => 'id',
					'terms'    => explode( ',', str_replace( ' ', '', $atts['cat'] ) ),
				),
			);
		}
		$style        = $atts['style'];
		$height       = wp_is_mobile() ? $atts['height-mobile'] : $atts['height'];
		$per_page     = $atts['per-page'];
		$container_id = 'content-slider-' . uniqid();
		$query        = new WP_Query( $args );
		$output       = '';
		$data         = array();
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$temp['content'] = get_the_content();

				$data[] = $temp;
			}
			wp_reset_postdata();
		}
		if ( ! empty( $data ) ) {
			ob_start();
			require locate_template( 'templates/partials/content-slider.php', false, false );
			$output .= ob_get_clean();
		}
		return $output;
	}
}
/**
 * Renders Images slider
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_images_slider_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids'                => '',
			'transition'         => '5000',
			'animation'          => '1500',
			'height'             => '350px',
			'show_pagination'    => 'on',
			'show_navigation'    => 'on',
			'image_size_desktop' => 'medium', // Accepts (thumbnails or dots).
			'image_size_mobile'  => 'medium', // Accepts (thumbnails or dots).
		),
		$atts,
		'anony_images_slider'
	);

	$slider_settings = array(

		'style'           => 'one',
		'height'          => $atts['height'],
		'show_pagination' => 'on' === $atts['show_pagination'] ? true : false,
		'show_navigation' => 'on' === $atts['show_navigation'] ? true : false,
		'pagination_type' => 'dots', // Accepts (thumbnails or dots).
		'slider_data'     => array(
			'transition' => $atts['transition'],
			'animation'  => $atts['animation'],
		),
	);

	$image_size = wp_is_mobile() ? $atts['image_size_mobile'] : $atts['image_size_desktop'];

	// Get the comma-separated IDs and convert them into an array.
	$ids  = explode( ',', str_replace( ' ', '', $atts['ids'] ) );
	$data = array();
	if ( ! empty( $ids ) ) {
		foreach ( $ids as $key => $id ) {
			$temp['id']             = absint( $id );
			$temp['permalink_full'] = wp_get_original_image_url( absint( $id ) );
			$temp['permalink']      = wp_get_attachment_image_url( absint( $id ), $image_size );
			$data[]                 = $temp;
		}
	}
	if ( empty( $data ) ) {
		return '';
	}

	if ( $slider_settings['show_pagination'] ) {

		$slider_nav = array();

		foreach ( $data as $index => $p ) :

			$slider_nav_temp['permalink']     = $p['permalink'];
			$slider_nav_temp['id']            = $p['id'];
			$slider_nav_temp['class']         = 0 === $index ? 'anony-active-slide ' : '';
			$slider_nav_temp['thumbnail_img'] = get_the_post_thumbnail( $p['id'], 'full' );
			$slider_nav[]                     = $slider_nav_temp;

		endforeach;
	}

	$output = '';
	ob_start();
	require locate_template( 'templates/images-slider.php', false, false );
	$output .= ob_get_clean();
	wp_enqueue_script( 'anony-featured-slider' );
	return $output;
}
/**
 * Renders posts slider
 *
 * @param  string $atts the shortcode attributes.
 * @return string
 */
function anony_posts_slider_shcode( $atts ) {
	$atts            = shortcode_atts(
		array(
			'slider_content'  => '', // Accepts (featured-cat or featured-post).
			'featured_cat'    => '0',
			'taxonomy'        => 'category',
			'post_type'       => 'post',
			'show_pagination' => 'on',
			'show_navigation' => 'on',
		),
		$atts,
		'anony_posts_slider'
	);
	$anony_options   = ANONY_Options_Model::get_instance();
	$slider_settings = array(

		'style'           => 'one',
		'show_read_more'  => false,
		'show_pagination' => 'on' === $atts['show_pagination'] ? true : false,
		'show_navigation' => 'on' === $atts['show_navigation'] ? true : false,
		'pagination_type' => 'dots', // Accepts (thumbnails or dots).
		'slider_data'     => array(
			'transition' => 5000,
			'animation'  => 1500,
		),
	);

	$message = '';

	$args = array(
		'post_type'      => $atts['post_type'],
		'posts_per_page' => 5,
		'order'          => 'ASC',
		// phpcs:disable WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		'meta_query'     => array(
			array(
				'key'     => '_thumbnail_id',
				'compare' => 'EXISTS',
			),
		),
		// phpcs:enable.
	);

	if ( 'featured-cat' === $atts['slider_content'] && '0' !== $atts['featured_cat'] ) {

		$freatured_cat = get_term_by(
			'id',
			absint( $atts['featured_cat'] ),
			$atts['taxonomy']
		);

		if ( $freatured_cat ) {
			$args['cat'] = $freatured_cat->term_id;
		} else {
			$message = esc_html__( 'Please make sure you select a category and its corresponding taxonomy from theme options->slider', 'smartpage' );
		}
	} elseif ( 'featured-post' === $anony_options->slider_content ) {
		// phpcs:disable
		$args['meta_key'] = 'anony__set_as_featured';
		// phpcs:enable.
	}

	$query = new WP_Query( $args );

	$data = array();

	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {
			$query->the_post();
			$data[] = anony_common_post_data();
		}

		wp_reset_postdata();
	}

	if ( $slider_settings['show_pagination'] ) {

		$slider_nav = array();

		foreach ( $data as $index => $p ) :

			$slider_nav_temp['permalink']     = $p['permalink'];
			$slider_nav_temp['id']            = $p['id'];
			$slider_nav_temp['title']         = $p['title'];
			$slider_nav_temp['class']         = 0 === $index ? 'anony-active-slide ' : '';
			$slider_nav_temp['thumbnail_img'] = get_the_post_thumbnail( $p['id'], 'full' );

			$slider_nav[] = $slider_nav_temp;

		endforeach;
	}

	$title_link = isset( $args['cat'] ) ? get_category_link( $args['cat'] ) : '#';

	$title_text = isset( $args['cat'] ) ? get_cat_name( $args['cat'] ) : __( 'Featured Posts', 'smartpage' );

	$output = '';
	ob_start();
	require locate_template( 'templates/featured-' . $slider_settings['style'] . '-view.php', false, false );
	$output .= ob_get_clean();
	wp_enqueue_script( 'anony-featured-slider' );
	return $output;
}

/**
 * Shape divider
 *
 * @param  string $atts    the shortcode attributes.
 * @return string
 */
function anony_shape_divider_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'shape' => '',
		),
		$atts,
		'anony_shape_divider'
	);
	ob_start();
	?>
	<style>
		.website-divider-container-165642 {
			overflow: hidden;
			position: absolute;
			width: 100%;
			height: 250px;
			z-index: -1;
			bottom: 0;
			}

		.divider-img-165642 {
			position: absolute;
			width: 100%;
			height: 250px;
			transform: scale(1, 1);
			bottom:0px;
			left: 0px;
			fill: rgb(224 224 224);
		}
	</style>
	<div id="divider_id" class="website-divider-container-165642">

		<svg xmlns="http://www.w3.org/2000/svg" class="divider-img-165642" viewBox="0 0 1080 137" preserveAspectRatio="none">
		<path d="M 0,137 V 59.03716 c 158.97703,52.21241 257.17659,0.48065 375.35967,2.17167 118.18308,1.69101 168.54911,29.1665 243.12679,30.10771 C 693.06415,92.25775 855.93515,29.278599 1080,73.61449 V 137 Z" style="opacity:0.85"></path>
		<path d="M 0,10.174557 C 83.419822,8.405668 117.65911,41.78116 204.11379,44.65308 290.56846,47.52499 396.02558,-7.4328 620.04248,94.40134 782.19141,29.627636 825.67279,15.823104 1080,98.55518 V 137 H 0 Z" style="opacity:0.5"></path>
		<path d="M 0,45.10182 C 216.27861,-66.146913 327.90348,63.09813 416.42665,63.52904 504.94982,63.95995 530.42054,22.125806 615.37532,25.210412 700.33012,28.295019 790.77619,132.60682 1080,31.125744 V 137 H 0 Z" style="opacity:0.25"></path>
		</svg>   

	</div>
	<?php
	return ob_get_clean();
}

/**
 * Renders row
 *
 * @param  string $atts    the shortcode attributes.
 * @param  string $content the shortcode content.
 * @return string
 */
function anony_row_shcode( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'classes' => '',
		),
		$atts,
		'anony_column'
	);

	if ( '' !== $atts['classes'] ) {
		$class = ' ' . $atts['classes'];
	} else {
		$class = '';
	}
	return '<div class="anony-grid-row' . $class . '">' . do_shortcode( $content ) . '</div>';
}

/**
 * Renders column
 *
 * @param  string $atts    the shortcode attributes.
 * @param  string $content the shortcode content.
 * @return string
 */
function anony_column_shcode( $atts, $content = null ) {
	$atts = shortcode_atts(
		array(
			'classes' => '',
		),
		$atts,
		'anony_column'
	);

	if ( '' !== $atts['classes'] ) {
		$class = ' ' . $atts['classes'];
	} else {
		$class = '';
	}
	return '<div class="anony-grid-col' . $class . '">' . $content . '</div>';
}
/**
 * Renders a banner
 *
 * @param  string $atts    the shortcode attributes.
 * @param  string $content the shortcode content.
 * @return string the text that is to be used to replace the shortcode.
 */
function anony_ltrtext_shcode( $atts, $content = null ) {
	return '<span dir="ltr">' . $content . '</span>';
}

/**
 * Renders a banner
 *
 * @param  string $atts The shortcode attributes.
 * @return string
 */
function anony_banner_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'style'          => 'default',
			'desktop-image'  => '',
			'desktop-height' => '450',
			'mobile-image'   => '',
			'mobile-height'  => '200',
		),
		$atts,
		'anony_banner'
	);

	if ( empty( $atts['desktop-image'] ) ) {
		return anony_admin_hint( 'Please add the desctop image url' );
	}
	// Defaults to desktop image.
	if ( empty( $atts['mobile-image'] ) ) {
		$atts['mobile-image'] = $atts['desktop-image'];
	}

	if ( wp_is_mobile() ) {
		$banner_bg = $atts['mobile-image'];
		$height    = $atts['mobile-height'];
	} else {
		$banner_bg = $atts['desktop-image'];
		$height    = $atts['desktop-height'];
	}
	ob_start();
	?>
	<div class="anony-bg-banner" style="background-image: url(<?php echo esc_url( site_url( $banner_bg ) ); ?>);height:<?php echo esc_attr( $height ); ?>px">
	</div>
	<?php
	return ob_get_clean();
}
/**
 * Section title
 *
 * @param  string $atts    the shortcode attributes.
 * @return string Title markup.
 */
function anony_section_title_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'style' => 'default',
			'title' => __( 'Section title', 'samrtpage' ),
		),
		$atts,
		'anony_section_title'
	);
	return anony_section_title( $atts['title'], $atts['style'] );
}

/**
 * Display products loop
 *
 * @param  string $atts    the shortcode attributes.
 * @return string Products loop output.
 */
function anony_products_loop_shcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'ids'                => '',
			'category'           => '',
			'author'             => '',
			'slider'             => 'off',
			'height'             => '500px',
			'width'              => '100vw',
			'item-width-desktop' => '320px',
			'item-width-mobile'  => '150px',
		),
		$atts,
		'anony_products_loop'
	);
	// Get the comma-separated IDs and convert them into an array.
	$ids = ! empty( $atts['ids'] ) ? explode( ',', str_replace( ' ', '', $atts['ids'] ) ) : '';

	$products_loop_args = array();
	if ( ! empty( $ids ) ) {
		$products_loop_args['include'] = $ids;
	}
	if ( ! empty( $atts['category'] ) ) {
		$products_loop_args['product_category_id'] = explode( ',', $atts['category'] );
		unset( $products_loop_args['include'] );
	}

	if ( ! empty( $atts['author'] ) ) {
		$products_loop_args['post_author'] = absint( $atts['author'] );
	}

	if ( 'on' === $atts['slider'] ) {
		$slider_class = ' anony-woocommerce-loop-slider';
	} else {
		$slider_class = '';
	}
	$container_id = uniqid( 'anony-products-loop-' );

	if ( wp_is_mobile() ) {
		$item_width = $atts['item-width-mobile'];
	} else {
		$item_width = $atts['item-width-desktop'];
	}
	ob_start();
	if ( 'on' === $atts['slider'] ) {
		?>
		<style>
			.anony-woocommerce-loop-slider.anony-woocommerce-loop{
				position:relative;
				max-width: <?php echo esc_html( $atts['width'] ); ?>;
				overflow:hidden;
				/*height:<?php echo esc_html( $atts['height'] ); ?>;*/
				margin:auto;
			}
			.anony-woocommerce-loop-slider.anony-woocommerce-loop ul.products  li{
				width:<?php echo esc_html( $item_width ); ?>!important;
				display:inline-block;
				vertical-align: top;
				float: none !important;
				clear: none !important;
			}
			.anony-woocommerce-loop-slider.anony-woocommerce-loop ul.products{
				position:relative;
				display:block;
				width:9999999px;
				transition: transform 2s ease-in-out;
				-webkit-transition: transform 2s ease-in-out;
				-moz-transition: transform 2s ease-in-out;
				-ms-transition: transform 2s ease-in-out;
				-o-transition: transform 2s ease-in-out;
			}
			
			/* -------------*/
			.anony-woocommerce-loop-slider .anony-slider-control{
				margin: auto;
				text-align: center;
				position: relative;
				bottom: auto;
			}
			body.rtl .anony-woocommerce-loop-slider .anony-slider-control{
				display: flex;
				justify-content: center;
				align-items: center;
				flex-direction: row-reverse;
			}
			.anony-woocommerce-loop-slider .anony-slider-nav .top, .anony-slider-nav .bottom {
				display: block;
				width: 10px;
				height: 1px;
				height: 1px;
				background-color: #fff;
			}
		
			.anony-woocommerce-loop-slider .anony-greater-than .top {
				transform: rotate(45deg);
				top: 8px;
				position: relative;
			}
		
			.anony-woocommerce-loop-slider .anony-greater-than .bottom {
				transform: rotate(-45deg);
			}
		
			.anony-woocommerce-loop-slider .anony-smaller-than .top {
				transform: rotate(-45deg);
				top: 8px;
				position: relative;
			}
		
			.anony-woocommerce-loop-slider .anony-smaller-than .bottom {
				transform: rotate(45deg);
			}
			.anony-woocommerce-loop-slider .anony-slider-control button{
				height: 35px;
				width: 35px;
				margin: 0 3px;
				background-color: rgb(0,0,0,0.5);
				color: #fff;
				outline: none;
				border-radius: 50%;
				border: none;
				cursor: pointer;
			}
			.anony-woocommerce-loop-slider .anony-slider-control button:hover{
				background-color: rgb(0,0,0,1);
			}
			.anony-woocommerce-loop-slider .anony-slider-nav{
				position: relative;
				top: -3px;
				display: flex;
				flex-direction: column;
				justify-content: center;
				align-items: center;
			}
			@media screen and (max-width:480px) {
				.anony-woocommerce-loop-slider .anony-slider div{
					max-width: calc(100vw - 40px);
				}
				.anony-woocommerce-loop-slider .anony-slide .wp-block-columns{
					flex-direction: column;
				}
			}
		</style>

		<?php
	}
	echo '<div id="' . esc_html( $container_id ) . '" class="woocommerce anony-woocommerce-loop anony-flex-grow' . esc_html( $slider_class ) . '">';

	ANONY_Woo_Help::products_loop(
		array(
			'loop_args' => $products_loop_args,
			'slider'    => $atts['slider'],
			'id'        => $container_id,
		)
	);

	if ( 'on' === $atts['slider'] ) {
		?>
		<div class="anony-slider-control" data-slider="<?php echo esc_html( $container_id ); ?>">
			<button class="anony-slider-prev">
				<span class="anony-greater-than anony-slider-nav">
					<span class="top"></span><span class="bottom"></span>
				</span>
			</button>
			<button class="anony-slider-next">
				<span class="anony-smaller-than anony-slider-nav">
					<span class="top"></span><span class="bottom"></span>
				</span>
			</button>
		</div>
		<?php
	}
	echo '</div>';

	if ( 'on' === $atts['slider'] ) {

		add_action(
			'wp_footer',
			function () use( $container_id ) {
				?>
		<script>
		jQuery(document).ready(function($) {
			var containerID = '<?php echo esc_html( $container_id ); ?>';

			var slideWidth = $('ul.products li', $( '#' + containerID )).outerWidth();
			
			var slider     = $('ul.products', $( '#' + containerID ));
			// Clone the first and last slide.
			var firstSlide = $('ul.products li:first-child', $( '#' + containerID )).clone();
			var lastSlide = $('ul.products li:last-child', $( '#' + containerID )).clone();
		
			// Append cloned slides to the slider.
			slider.append(firstSlide);
			slider.prepend(lastSlide);
			
			var margins = 0
			$('li.product', $( '#' + containerID )).each( function() {
				margins = margins + parseFloat( $(this).css("marginRight").replace('px', '' ) );
			} );
			var itemsLength = $('ul.products li', $( '#' + containerID )).length;
			// Adjust the slider width.
			var sliderWidth = slideWidth * itemsLength + ( 10 * itemsLength ) + margins ;
		
			slider.width( sliderWidth );
			// Set initial position.
				<?php if ( ! is_rtl() ) { ?>
			var initialPosition = -slideWidth;
			<?php } else { ?>
				var initialPosition = slideWidth;
			<?php } ?>
			if ( 3 > $('ul.products li', $( '#' + containerID )).length ) {
				
			}
			slider.css('transform', 'translateX(' + initialPosition + 'px)');
			
			// Slide to the next slide.
			$( '#' + containerID ).on('click','.anony-slider-next', function() {
		
		
				$( '#' + containerID ).find( 'ul.products' ).animate(
				{ 'margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>': '-=' + slideWidth },
				300,
				function() {
					slider.css('margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>', 0);
					slider.append($('ul.products li:first-child', $( '#' + containerID )));
				}
				);
			});
		
			// Slide to the previous slide.
			$( '#' + containerID ).on('click','.anony-slider-prev', function() {
		
				$( '#' + containerID ).find( 'ul.products' ).animate(
				{ 'margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>': '+=' + slideWidth },
				300,
				function() {
					slider.css('margin-<?php echo ! is_rtl() ? 'left' : 'right'; ?>', 0);
					slider.prepend($('ul.products li:last-child', $( '#' + containerID )));
				}
				);
			});
		
			
		});
		</script>
				<?php
			}
		);
	}
	return ob_get_clean();
}