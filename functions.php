<?php
/**
 * Theme functions
 *
 * PHP version 7.3 Or Later
 *
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com/smartpage
 */

defined( 'ABSPATH' ) || die(); // Exit if accessed direct.

require_once wp_normalize_path( get_template_directory() . '/config/config.php' );

// Initial functions files.

/**
 * Theme update checker.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'updates.php' );

/**
 * Theme Scripts.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'scripts.php' );

/**
 * Theme helper functions.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'theme-helpers.php' );

/**
 * Theme menus.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'menus.php' );


if ( ! defined( 'ANOENGINE' ) ) {
	// Load defaults.
	add_filter( 'template_include', 'anony_load_defaults' );
	return;
}

// Main functions files.

/**
 * Theme features.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'theme.php' );

/**
 * Theme options.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'theme-options.php' );

/**
 * Data injection.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'data-hooks.php' );

/**
 * Posts registrations.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'posts.php' );

if ( class_exists( 'woocommerce' ) ) {
	/**
	 * WooCommerce.
	 */
	require_once wp_normalize_path( ANONY_LIBS_DIR . 'woocommerce.php' );
}


/**
 * Performance.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'performance.php' );

/**
 * Admin area.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'admin.php' );

/**
 * Media handing.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'media.php' );

/**
 * Widgets registration.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'widgets.php' );

/**
 * Custom fields.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'custom-fields.php' );


/**
 * Comments AJAX.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'ajax/ajax-comments.php' );

/**
 * Download AJAX.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'ajax/ajax-download.php' );

/**
 * Rating AJAX.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'ajax/ajax-rate.php' );

/**
 * TinyMCE buttons.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'mce/tinymce-editor-btns.php' );


/**
 * Custom shortcodes.
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'shortcodes/statistics/statistics.php' );

/**
 * Visual composer includes
 */
require_once wp_normalize_path( ANONY_LIBS_DIR . 'vc-includes.php' );
require_once wp_normalize_path( ANONY_LIBS_DIR . 'vc-shortcode-types/switch.php' );


/**
 * Elementor includes
 */
require_once wp_normalize_path( ANONY_ELEMENTOR_EXTENSION . 'elementor-incl.php' );


require ANONY_THEME_DIR . '/plugin-update-checker/plugin-update-checker.php';

Puc_v4_Factory::buildUpdateChecker(
	'https://raw.githubusercontent.com/MakiOmar/smartpage/master/plugin-update-checker/examples/theme.json',
	__FILE__, // Full path to the main plugin file or functions.php.
	'anony-smartpage'
);

add_filter(
	'wcfm_vendor_settings_fields_policies',
	function ( $fields ) {
		$user_id = apply_filters( 'wcfm_current_vendor_id', get_current_user_id() );

		$vendor_data                = get_user_meta( $user_id, 'wcfmmp_profile_settings', true );
		$return_accepted            = isset( $vendor_data['return_accepted'] ) ? esc_attr( $vendor_data['return_accepted'] ) : 'no';
		$return_within              = isset( $vendor_data['return_within'] ) ? esc_attr( $vendor_data['return_within'] ) : '30';
		$_fields['return_accepted'] = array(
			'label'       => __( 'Accept return', 'wc-frontend-manager' ),
			'type'        => 'select',
			'class'       => 'wcfm-select wcfm_ele',
			'label_class' => 'wcfm_title wcfm_ele',
			'value'       => $return_accepted,
			'options'     => array(
				'yes' => 'yes',
				'no'  => 'no',
			),
		);

		$_fields['return_within'] = array(
			'label'       => __( 'Return within', 'wc-frontend-manager' ),
			'type'        => 'number',
			'class'       => 'wcfm-text wcfm_ele',
			'label_class' => 'wcfm_title wcfm_ele',
			'value'       => $return_within,
			'hints'       => __( 'Allowed to reteun within x days', 'wc-frontend-manager' ),
			'placeholder' => 'e.g. 30 Days',
		);

		$faqs           = isset( $vendor_data['faqs'] ) ? $vendor_data['faqs'] : array();
		$fields['faqs'] = array(
			'label'       => __( 'FAQs', 'wc-frontend-manager' ),
			'type'        => 'multiinput',
			'class'       => 'wcfm-text wcfm_ele',
			'label_class' => 'wcfm_title',
			'desc_class'  => 'instructions',
			'value'       => $faqs,

			'options'     => array(

				'question' => array(
					'label'       => __( 'Question', 'wc-frontend-manager' ),
					'type'        => 'text',
					'class'       => 'wcfm-text wcfm_ele',
					'label_class' => 'wcfm_title',
				),

				'answer'   => array(
					'label'       => __( 'Answer', 'wc-frontend-manager' ),
					'type'        => 'text',
					'class'       => 'wcfm-text wcfm_ele',
					'label_class' => 'wcfm_title',
				),

			),
		);

		return array_merge( $_fields, $fields );
	}
);

/**
 * Track deprecated functions.
 * **Description: ** Should be hooked to deprecated_argument_run | doing_it_wrong_run
 *
 * @param string $function The function that was called.
 * @param string $message  A message regarding the change.
 * @param string $version  The version of WordPress that deprecated the argument used.
 * @return void
 */

$form = array(
	'id'              => 'update-user',
	'fields_layout'   => 'columns',
	'form_attributes' => array(
		'action'  => '',
		'method'  => 'post',
		'enctype' => 'multipart/form-data',
	),
	'fields'          => array(
		array(
			'id'       => 'profile-image',
			'title'    => 'Profile image',
			'validate' => 'no_html',
			'type'     => 'uploader',
			'style'    => 'two',
		),

	),
	'action_list'     => array(
		'Update_User' => array(
			'user_data' => array(
				'ID' => get_current_user_id(),
			),
			'meta'      => array(
				'profile-image' => '#profile-image',
			),

		),
	),

	'conditions'      => array(
		'logged_in' => true,
		'user_role' => array( 'administrator', 'subscriber' ),
	),
	'defaults'        => array(
		'object_type'    => 'user', // Accepts post, term, user.
		'object_id_from' => 'current_user', // Accepts current_user, current_term, current_post or query_variable.
	),
);

$init = new ANONY_Create_Form( $form );

//phpcs:disable
$form = array(
	'id'              => 'user_insert_profile',
	'fields_layout'   => 'columns',
	'form_attributes' => array(
		'action'  => '',
		'method'  => 'post',
		'enctype' => 'multipart/form-data',
	),
	'fields'          => array(
		array(
			'id'       => 'thumb2',
			'validate' => 'no_html',
			'type'     => 'uploader',
			'style'    => 'two',

		),

		array(
			'id'           => 'category',
			'validate'     => 'no_html',
			'type'         => 'select',
			'options'      => ANONY_TERM_HELP::wp_top_level_term_query( 'provider_categories', 'id=>name' ),
			'first_option' => 'القسم',
			'on_change'    => array(
				'target' => 'sub_category', // Field ID to be affected after this field change.
				'action' => 'get_term_children_options', // ajax action to trigger. Predefined actions ( get_term_children_options )
				'data'   => array(
					'taxonomy' => 'provider_categories',
				), // Data sent with ajax request
			),

		),

		array(
			'id'           => 'sub_category',
			'validate'     => 'no_html',
			'type'         => 'select',
			'options'      => array(),
			'first_option' => 'القسم الفرعي',
		),

		array(
			'id'          => 'title',
			'placeholder' => 'إسم العمل',
			'validate'    => 'no_html',
			'type'        => 'text',

		),


		array(
			'id'          => 'location',
			'placeholder' => 'العنوان',
			'validate'    => 'no_html',
			'type'        => 'location',
		),
		array(
			'id'              => 'phone',
			'placeholder'     => 'رقم الهاتف',
			'validate'        => 'no_html',
			'type'            => 'tel',
			'with-dial-codes' => 'yes',
		),

		array(
			'id'              => 'second_phone',
			'placeholder'     => 'رقم هاتف آخر',
			'validate'        => 'no_html',
			'type'            => 'tel',
			'with-dial-codes' => 'yes',
		),

		array(
			'id'              => 'whatsapp',
			'placeholder'     => 'واتساب',
			'validate'        => 'no_html',
			'type'            => 'tel',
			'with-dial-codes' => 'yes',
		),

		array(
			'id'          => 'website',
			'placeholder' => 'الموقع الآلكتروني',
			'type'        => 'url',
			'validate'    => 'no_html',
		),

		array(
			'id'          => 'facebook',
			'placeholder' => 'صفحة الفيسبوك',
			'type'        => 'url',
			'validate'    => 'no_html',
		),

		array(
			'id'          => 'instagram',
			'placeholder' => 'صفحة إنستاجرام',
			'type'        => 'url',
			'validate'    => 'no_html',
		),

		array(
			'id'          => 'description',
			'placeholder' => 'الوصف',
			'type'        => 'textarea',
			'validate'    => 'no_html',
		),
		array(
			'id'          => 'gallery',
			'title'       => esc_html__( 'gallery', 'smartpage' ),
			'type'        => 'gallery',
			'validate'    => 'no_html',
			'button_text' => 'Add to gallery',
		),
	),
	'action_list'     => array(
		'Update_Post' => array(
			'post_data' => array(
				'post_title'   => '#title', // This field will map to the field input of name title;
				'post_status'  => 'pending', // This field will equal to this value;
				'post_type'    => 'providers',
				'post_content' => '#description',
			),
			'meta'      => array(
				'location'      => '#location',
				'phone'         => '#phone',
				'second_phone'  => '#second_phone',
				'whatsapp'      => '#whatsapp',
				'website'       => '#website',
				'facebook'      => '#facebook',
				'instagram'     => '#instagram',
				'_thumbnail_id' => '#thumb',
				'gallery'       => '#gallery',
			),
			// As taxonomy => #field_id.
			'tax_query' => array(

				'provider_categories' => array( '#category', '#sub_category' ),

			),

		),
	),

	'conditions'      => array(
		'logged_in' => true,
		'user_role' => array( 'administrator', 'subscriber' ),
	),
	'defaults'        => array(
		'object_type'    => 'post', // Accepts post, term, user
		'object_id_from' => 'query_variable', // Accepts current_user, current_term, current_post or query_variable
		'query_variable' => '_post_id',
	),
);

$init = new ANONY_Create_Form( $form );

$form = array(
	'id'              => 'user_profile',
	'fields_layout'   => 'columns',
	'form_attributes' => array(
		'action'  => '',
		'method'  => 'post',
		'enctype' => 'multipart/form-data',
	),
	'fields'          => array(
		array(
			'id'          => 'thumb',
			'validate'    => 'no_html',
			'type'        => 'uploader',
			'style'       => 'one',

		),

		array(
			'id'          => 'title',
			'placeholder' => 'إسم العمل',
			'validate'    => 'no_html',
			'type'        => 'text',

		),


		array(
			'id'          => 'location',
			'placeholder' => 'العنوان',
			'validate'    => 'no_html',
			'type'        => 'location',
		),
		array(
			'id'              => 'phone',
			'placeholder'     => 'رقم الهاتف',
			'validate'        => 'no_html',
			'type'            => 'tel',
			'with-dial-codes' => 'yes',
		),

		array(
			'id'              => 'second_phone',
			'placeholder'     => 'رقم هاتف آخر',
			'validate'        => 'no_html',
			'type'            => 'tel',
			'with-dial-codes' => 'yes',
		),

		array(
			'id'              => 'whatsapp',
			'placeholder'     => 'واتساب',
			'validate'        => 'no_html',
			'type'            => 'tel',
			'with-dial-codes' => 'yes',
		),

		array(
			'id'          => 'website',
			'placeholder' => 'الموقع الآلكتروني',
			'type'        => 'url',
			'validate'    => 'no_html',
		),

		array(
			'id'          => 'facebook',
			'placeholder' => 'صفحة الفيسبوك',
			'type'        => 'url',
			'validate'    => 'no_html',
		),

		array(
			'id'          => 'instagram',
			'placeholder' => 'صفحة إنستاجرام',
			'type'        => 'url',
			'validate'    => 'no_html',
		),

		array(
			'id'          => 'description',
			'placeholder' => 'الوصف',
			'type'        => 'textarea',
			'validate'    => 'no_html',
		),
	),
	'action_list'     => array(
		'Profile' => array(
			'post_data' => array(
				'post_title'   => '#title', // This field will map to the field input of name title;
				'post_status'  => 'pending', // This field will equal to this value;
				'post_type'    => 'profile',
				'post_content' => '#description',
			),
			'meta'      => array(
				'location'      => '#location',
				'phone'         => '#phone',
				'second_phone'  => '#second_phone',
				'whatsapp'      => '#whatsapp',
				'website'       => '#website',
				'facebook'      => '#facebook',
				'instagram'     => '#instagram',
				'_thumbnail_id' => '#thumb',
			),

		),
	),

	'conditions'      => array(
		'logged_in' => true,
		'user_role' => array( 'administrator', 'subscriber' ),
	),

);

$init = new ANONY_Create_Form($form);


add_filter(
	'sub_category_first_option',
	function () {
		return 'القسم الفرعي';
	}
);

add_filter(
	'anony_location_icon',
	function () {
		return '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 19.5C16.1421 19.5 19.5 16.1421 19.5 12C19.5 7.85786 16.1421 4.5 12 4.5C7.85786 4.5 4.5 7.85786 4.5 12C4.5 16.1421 7.85786 19.5 12 19.5Z" stroke="#6A9DD2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#6A9DD2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12 4V2" stroke="#6A9DD2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M4 12H2" stroke="#6A9DD2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M12 20V22" stroke="#6A9DD2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M20 12H22" stroke="#6A9DD2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';
	}
);

add_filter(
	'anony_profile-image_icon',
	function () {
		return '<svg width="89" height="94" viewBox="0 0 89 94" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M44.9556 44.25C57.1058 44.25 66.9556 34.4003 66.9556 22.25C66.9556 10.0997 57.1058 0.25 44.9556 0.25C32.8053 0.25 22.9556 10.0997 22.9556 22.25C22.9556 34.4003 32.8053 44.25 44.9556 44.25Z" fill="#E3E3E3"/>
        <path d="M88.9556 93.75V71.75C88.9556 68.45 87.3056 65.15 84.5556 62.95C78.5056 58 70.8056 54.7 63.1056 52.5C57.6056 50.85 51.5556 49.75 44.9556 49.75C38.9056 49.75 32.8556 50.85 26.8056 52.5C19.1056 54.7 11.4056 58.55 5.35557 62.95C2.60557 65.15 0.955566 68.45 0.955566 71.75V93.75H88.9556Z" fill="#E3E3E3"/>
        </svg>
        ';
	}
);

add_filter(
	'anony_tel_icon',
	function () {
		return '<svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17 6V16C17 20 16 21 12 21H6C2 21 1 20 1 16V6C1 2 2 1 6 1H12C16 1 17 2 17 6Z" stroke="#6A9DD2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M11 4.5H7" stroke="#6A9DD2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M9.0002 18.1C9.85624 18.1 10.5502 17.406 10.5502 16.55C10.5502 15.694 9.85624 15 9.0002 15C8.14415 15 7.4502 15.694 7.4502 16.55C7.4502 17.406 8.14415 18.1 9.0002 18.1Z" stroke="#6A9DD2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>';
	}
);