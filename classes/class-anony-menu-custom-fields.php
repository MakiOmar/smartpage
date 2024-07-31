<?php
/**
 * Menu item icon
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Menu item icon
 *
 * @package Anonymous theme
 * @author  Makiomar
 */
final class ANONY_Menu_Custom_Fields {

	/**
	 * Fields to add
	 *
	 * @var array
	 */
	public static array $field_keys = array(

		'_menu_item_svg_icon' => array(
			'title' => 'Choose an SVG icon',
		),

	);
	/**
	 * Init
	 *
	 * @return void
	 */
	public static function init(): void {

		if ( is_admin() ) {
			add_action( 'wp_nav_menu_item_custom_fields', array( __CLASS__, 'add_fileds' ), 10 );
			add_action( 'wp_update_nav_menu_item', array( __CLASS__, 'save_fields' ), 10, 2 );
		} else {
			add_filter( 'walker_nav_menu_start_el', array( __CLASS__, 'nav_menu_start_el' ), 10, 2 );
			add_filter( 'wp_nav_menu_args', array( __CLASS__, 'nav_menu_args' ) );
		}
	}

	/**
	 * Add fields
	 *
	 * @param string $item_id Menu item ID as a numeric string.
	 * @return void
	 */
	public static function add_fileds( $item_id ) {

		foreach ( self::$field_keys as $meta_key => $data ) {

			$value = get_post_meta( $item_id, $meta_key, true );
			$title = $data['title'];
			$type  = $data['type'] ?? 'text';
			$size  = $data['size'] ?? 'wide';
			$desc  = empty( $data['desc'] ) ? '' : '<span class="description">' . $data['desc'] . '</span>';
			?>
			<div class="field-<?php echo esc_attr( $meta_key ); ?> description description-<?php echo esc_attr( $size ); ?>">
				<br/>
				<?php
				$field = array(
					'id'       => sprintf( '%s-%s', esc_attr( $meta_key ), esc_attr( $item_id ) ),
					'name'     => sprintf( '%s[%s]', esc_attr( $meta_key ), esc_attr( $item_id ) ),
					'title'    => $title,
					'type'     => 'uploader',
					'validate' => 'no_html',
					'desc'     => wp_kses( $desc, array( 'span' => array( 'class' => array() ) ) ),
				);

				$args = array(
					'field'       => $field,
					'form_id'     => '',
					'object_id'   => $item_id,
					'field_value' => esc_attr( $value ),
					'context'     => 'meta',
				);
				if ( class_exists( 'ANONY_Input_Base' ) ) {
					$render_field = new ANONY_Input_Base( $args );
					//phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
					echo $render_field->field_init();
					//phpcs:enable.
					new ANONY_Fields_Scripts( array( $field ) );
				}
				?>
			</div>
			<?php
		}
	}
	/**
	 * Save fields
	 *
	 * @param int $menu_id ID of the updated menu.
	 * @param int $item_id ID of the updated menu item.
	 * @return void
	 */
	public static function save_fields( $menu_id, $item_id ) {

		foreach ( self::$field_keys as $meta_key => $data ) {
			self::save_field( $menu_id, $item_id, $meta_key );
		}
	}
	/**
	 * Save menu item custom field.
	 *
	 * @param int    $menu_id ID of the updated menu.
	 * @param int    $item_id ID of the updated menu item.
	 * @param string $meta_key Meta key.
	 * @return void
	 */
	private static function save_field( $menu_id, $item_id, $meta_key ) {
		//phpcs:disable WordPress.Security.NonceVerification.Missing
		$req = $_POST;
		//phpcs:enable.
		if ( ! isset( $req[ $meta_key ][ $item_id ] ) ) {
			return;
		}

		$val = $req[ $meta_key ][ $item_id ];

		if ( $val ) {
			update_post_meta( $item_id, $meta_key, sanitize_text_field( $val ) );
		} else {
			delete_post_meta( $item_id, $meta_key );
		}
	}
	/**
	 * Get svg by id.
	 *
	 * @param string $svg_id SVG ID.
	 * @return string
	 */
	public static function get_svg( $svg_id ) {

		$svg_url = wp_get_attachment_url( $svg_id );

		if ( $svg_url ) {
			$response = wp_remote_get( $svg_url );

			if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
				return wp_remote_retrieve_body( $response );
			} else {
				return '<img src="' . $svg_url . '"/>';
			}
		}

		return '';
	}
	/**
	 * Filter menu item start el.
	 *
	 * @param string  $item_output The menu item’s starting HTML output.
	 * @param WP_Post $post Menu item data object.
	 * @return string
	 */
	public static function nav_menu_start_el( $item_output, $post ) {

		$svg = $post->_menu_item_svg_icon ? $post->_menu_item_svg_icon : '';
		if ( $svg ) {
			$svg = '<span style="width:25px;height:25px;display:inline-flex;justify-content:center;align-items:center;margin:0 3px">&nbsp;' . self::get_svg( $svg ) . '</span>';
		}

		return str_replace( '{SVG}', $svg, $item_output );
	}
	/**
	 * Menu item args.
	 *
	 * @param array $args Menu item args.
	 * @return array
	 */
	public static function nav_menu_args( $args ) {

		if ( empty( $args['link_before'] ) ) {
			$args['link_before'] = '{SVG}';
		}

		return $args;
	}
}
