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
			'title' => 'SVG Icon Name',
			'desc'  => 'Set svg icon name (not url)',
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

			$desc = empty( $data['desc'] ) ? '' : '<span class="description">' . $data['desc'] . '</span>';
			?>
			<p class="field-<?php echo esc_attr( $meta_key ); ?> description description-<?php echo esc_attr( $size ); ?>">
				<?php echo esc_html( $title ); ?>
				<br/>
				<input class="widefat edit-menu-item-<?php echo esc_attr( $meta_key ); ?>"
						type="<?php echo esc_attr( $type ); ?>"
						name="<?php printf( '%s[%s]', esc_attr( $meta_key ), esc_attr( $item_id ) ); ?>"
						id="menu-item-<?php echo esc_attr( $item_id ); ?>"
						value="<?php echo esc_attr( $value ); ?>"/>

				<?php echo wp_kses( $desc, array( 'span' => array( 'class' => array() ) ) ); ?>
			</p>
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
	 * Get svg by name.
	 *
	 * @param string $svg_name SVG namè.
	 * @return string
	 */
	public static function get_svg( $svg_name ) {
		return $svg_name;
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
			$svg = self::get_svg( $svg );
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
