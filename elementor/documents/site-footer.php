<?php namespace ANONYELEMENTOR\Documents;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}

use Elementor\Controls_Manager;
use Elementor\Core\Base\Document;
use Elementor\Group_Control_Background;
use Elementor\Plugin as Elementor;
use Elementor\Utils;
use Elementor\Modules\Library\Documents\Library_Document;


/**
 * SiteHeader
 */
final class ANONY_Site_Footer extends Library_Document {

	/**
	 * Get document properties.
	 *
	 * Retrieve the document properties.
	 *
	 * @since  2.0.0
	 * @access public
	 * @static
	 *
	 * @return array Document properties.
	 */
	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['admin_tab_group']           = 'library';
		$properties['support_wp_page_templates'] = true;
		$properties['support_kit']               = true;
		$properties['register_type']             = true;
		$properties['edit_capability']           = true;
		$properties['show_in_library']           = true;

		return $properties;
	}

	/**
	 * Get document name.
	 *
	 * Retrieve the document name.
	 *
	 * @since  2.0.0
	 * @access public
	 *
	 * @return string Document name.
	 */
	public function get_name() {
		return 'site_footer';
	}

	/**
	 * @return string Document title.
	 */
	public static function get_title() {
		return __( 'Site Footer', 'smartpage' );
	}

	/**
	 * @return string
	 */
	public function get_css_wrapper_selector() {
		return '#anony-site-footer';
	}

	/**
	 * Override container attributes
	 */
	public function get_container_attributes() {
		$id = $this->get_main_id();

		$settings = $this->get_frontend_settings();

		$attributes = array(
			'data-elementor-type' => $this->get_name(),
			'data-elementor-id'   => $id,
			'class'               => 'elementor elementor-' . $id . ' anony-site-footer',
		);

		if ( ! Elementor::$instance->preview->is_preview_mode( $id ) ) {
			$attributes['data-elementor-settings'] = wp_json_encode( $settings );
		}

		return $attributes;
	}

	/**
	 * Override wrapper to insert `header` tag and other neccessary stuff.
	 */
	public function print_elements_with_wrapper( $elements_data = null ) {
		if ( ! $elements_data ) {
			$elements_data = $this->get_elements_data();
		}
		wp_body_open();

		do_action( 'anony_before_render_site_footer', $elements_data );
		?>

		<footer id="anony-site-header" <?php echo Utils::render_html_attributes( $this->get_container_attributes() ); ?>>
			<div class="elementor-inner">
				<div class="elementor-section-wrap">
		<?php $this->print_elements( $elements_data ); ?>
				</div>
			</div>
		</footer>
		<?php

		do_action( 'anony_after_render_site_footer', $elements_data );
	}

	/**
	 * Register controls
	 */
	protected function register_controls() {
		parent::register_controls();
	}



	protected function get_remote_library_config() {
		$config = parent::get_remote_library_config();

		$config['type'] = 'site_footer';

		return $config;
	}
}
