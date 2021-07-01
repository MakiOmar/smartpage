<?php
if ( ! defined( 'ABSPATH' ) )  exit; 

if (!function_exists('anony_control_query_strings')) {
	//controls add query strings to scripts/styles
	function anony_control_query_strings($src, $handle){
		if(is_admin()) return $src;

		$anonyOptions = ANONY_Options_Model::get_instance();
		
		//Keep query string for these items
		$neglected = array();
		
		if(!empty($anonyOptions->keep_query_string)){
			$neglected = explode(',',$anonyOptions->keep_query_string);
		}
		
		if($anonyOptions->query_string != '0' && !in_array( $handle, $neglected )){
			$src = remove_query_arg('ver', $src);
		}
		return $src;
		
	}
}

add_filter('style_loader_tag', function($tag){
	if(is_admin()) return $tag;
	
	$anonyOptions = ANONY_Options_Model::get_instance();
	
	if($anonyOptions->defer_stylesheets !== '1') return $tag;
	
    $tag = preg_replace("/media='\w+'/", "media='print' onload=\"this.media='all'\"", $tag);

    return $tag;
});



//controls add query strings to scripts
add_filter( 'script_loader_src', 'anony_control_query_strings', 15, 2 );

//controls add query strings to styles
add_filter( 'style_loader_src', 'anony_control_query_strings', 15, 2);

//Use custom avatar instead of Gravatar.com
add_filter( 'get_avatar', function($avatar){
	$anonyOptions = ANONY_Options_Model::get_instance();
	
	if(!$anonyOptions->gravatar || $anonyOptions->gravatar != '1') return $avatar;
	
	$avatar = '<img src="'.ANONY_THEME_URI.'/images/user.png" width="48" height="48"/>';
    return $avatar;
}, 200 );


if (!function_exists('anony_disable_wp_embeds')) {
	
	function anony_disable_wp_embeds(){
		$anonyOptions = ANONY_Options_Model::get_instance();
		
		$keep = true;
		
		if($anonyOptions->disable_embeds == '1' ) $keep = false;
		
		if($anonyOptions->enable_singular_embeds == '1' && is_single()) $keep = true;

		if($keep) return;
		
		// Remove the REST API endpoint.
		remove_action( 'rest_api_init', 'wp_oembed_register_route' );

		// Turn off oEmbed auto discovery.
		add_filter( 'embed_oembed_discover', '__return_false' );

		// Don't filter oEmbed results.
		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

		// Remove oEmbed discovery links.
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

		// Remove oEmbed-specific JavaScript from the front-end and back-end.
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		
		add_filter( 'tiny_mce_plugins', function ($plugins) {
			return array_diff($plugins, array('wpembed'));
		});

		// Remove all embeds rewrite rules.
		add_filter( 'rewrite_rules_array', function($rules) {
			foreach($rules as $rule => $rewrite) {
			    if(false !== strpos($rewrite, 'embed=true')) {
			        unset($rules[$rule]);
			    }
			}
			return $rules;
		} );

		// Remove filter of the oEmbed result before any HTTP requests are made.
		remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );
	}
}

if (!function_exists('anony_disable_wp_emojis')) {
	
	function anony_disable_wp_emojis(){
		$anonyOptions = ANONY_Options_Model::get_instance();
		
		$keep = true;
		
		if($anonyOptions->disable_emojis == '1' ) $keep = false;
		
		if($anonyOptions->enable_singular_emojis == '1' && is_single()) $keep = true;

		if($keep) return;
		
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		
		/**
		 * Filter function used to remove the tinymce emoji plugin.
		 * 
		 * @param  array $plugins 
		 * @return array Difference betwen the two arrays
		 */
		add_filter( 'tiny_mce_plugins', function( $plugins ) {

			return ( is_array( $plugins ) ) ? array_diff( $plugins, array( 'wpemoji' ) ) : [];
		} );
		
		
		/**
		 * Remove emoji CDN hostname from DNS prefetching hints.
		 *
		 * @param  array $urls URLs to print for resource hints.
		 * @param  string $relation_type The relation type the URLs are printed for.
		 * @return array Difference betwen the two arrays.
		 */
		add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {
			if ( 'dns-prefetch' == $relation_type ) {
				/** This filter is documented in wp-includes/formatting.php */
				$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

				$urls = array_diff( $urls, array( $emoji_svg_url ) );
			}

			return $urls;
		}, 10, 2 );
	}
}

//template_redirect runs before page/post is rendered
add_action( 'template_redirect', function () {
	
	//Remove WP embeds
	anony_disable_wp_embeds();
	
	//Remove WP emojies
	anony_disable_wp_emojis();
	
}, 9999 );

if (!function_exists('anony_load_cf7_scripts')) {
	/**
	 * Only loads contact form 7 scripts/styles if needed
	 */
	function anony_load_cf7_scripts($return){
		
		if(!is_page() || is_front_page() || is_home()) return '__return_false';
		
		global $post;
		
		$anonyOptions = ANONY_Options_Model::get_instance();
		
		if(!$anonyOptions->cf7_scripts || $anonyOptions->cf7_scripts == '' || intval($anonyOptions->cf7_scripts) !== $post->ID ) return $return;
		
		setup_postdata($post);
		
		$content = get_the_content();
		
		if (!has_shortcode(  $content, 'contact-form-7' )) return '__return_false';
	    
	    return $return;
	}
}


add_filter( 'wpcf7_load_js', 'anony_load_cf7_scripts', 11 );
add_filter( 'wpcf7_load_css', 'anony_load_cf7_scripts', 11 );


//Dequeue unwanted style
add_action( 'wp_print_styles',  function(){
	$anonyOptions = ANONY_Options_Model::get_instance();
	
    $dequeued_styles = [
            'wpml-tm-admin-bar', 
        ];
        
    if($anonyOptions->disable_gutenburg_scripts == '1'){
    	$dequeued_styles = array_merge($dequeued_styles, ['wp-block-library', 'wp-block-library-theme', 'wc-block-style'] );
    }
    
    if(is_page()){
    	
    	global $post;
    	
    	if (intval($anonyOptions->cf7_scripts) !== $post->ID) {
    		$dequeued_styles = array_merge($dequeued_styles, ['contact-form-7'] );
    	}
    	
    }else{
    	$dequeued_styles = array_merge($dequeued_styles, ['contact-form-7'] );
    }

    foreach($dequeued_styles as $style){
        wp_dequeue_style( $style );
        wp_deregister_style( $style );
    }
    
}, 99);

//Dequeue unwanted scripts
add_action( 'wp_print_scripts',  function(){
	$anonyOptions = ANONY_Options_Model::get_instance();
	
    $dequeued_scripts = [];
    
    
    if(is_page()){
    	
    	global $post;
    	
    	if (intval($anonyOptions->cf7_scripts) !== $post->ID) {
    		$dequeued_scripts = array_merge($dequeued_scripts, ['contact-form-7', 'google-recaptcha'] );
    	}
    	
    }else{
    	$dequeued_scripts = array_merge($dequeued_scripts, ['contact-form-7', 'google-recaptcha'] );
    }

    foreach($dequeued_scripts as $script){
        wp_dequeue_script( $script );
        wp_deregister_script( $script );
    }
    
}, 99);


//This will prevent the jQuery Migrate script from being loaded on the front end while keeping the jQuery script itself intact. It's still being loaded in the admin to not break anything there.
add_action( 'wp_default_scripts', function( $scripts ) {
	
	$anonyOptions = ANONY_Options_Model::get_instance();
	
	if($anonyOptions->disable_jq_migrate != '1') return;
	
    if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff(
            $scripts->registered['jquery']->deps,
            [ 'jquery-migrate' ]
        );
    }
} );

/** Disable All WooCommerce  Styles and Scripts Except Shop Pages*/
add_action( 'wp_enqueue_scripts', function() {
	$anonyOptions = ANONY_Options_Model::get_instance();
	
	if ($anonyOptions->wc_shop_only_scripts != 1) return;
	
	//Check if woocommerce plugin is active
	if ( function_exists( 'is_woocommerce' ) ) {
		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
			# Styles
			wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
			wp_dequeue_style( 'woocommerce_frontend_styles' );
			wp_dequeue_style( 'woocommerce_fancybox_styles' );
			wp_dequeue_style( 'woocommerce_chosen_styles' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			# Scripts
			wp_dequeue_script( 'wc_price_slider' );
			wp_dequeue_script( 'wc-single-product' );
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'wc-cart-fragments' );
			wp_dequeue_script( 'wc-checkout' );
			wp_dequeue_script( 'wc-add-to-cart-variation' );
			wp_dequeue_script( 'wc-single-product' );
			wp_dequeue_script( 'wc-cart' );
			wp_dequeue_script( 'wc-chosen' );
			wp_dequeue_script( 'woocommerce' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_script( 'jquery-blockui' );
			wp_dequeue_script( 'jquery-placeholder' );
			wp_dequeue_script( 'fancybox' );
			wp_dequeue_script( 'jqueryui' );
		}
	}
	
	
}, 11);

//Fix: Notice: ob_end_flush(): failed to send buffer of zlib output compression
if(ini_get('zlib.output_compression') == '1'){
	/**
	 * Proper ob_end_flush() for all levels
	 *
	 * This replaces the WordPress `wp_ob_end_flush_all()` function
	 * with a replacement that doesn't cause PHP notices.
	 */
	remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
}

add_filter('post_thumbnail_html', function($html, $post_id, $post_image_id, $size, $attr){
	
	$anonyOptions = ANONY_Options_Model::get_instance();
	
	if($anonyOptions->disable_prettyphoto == '1') return $html;
	
	    $html = '<a href="' . get_the_post_thumbnail_url($post_id, 'full') . '" rel="prettyPhoto" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . wp_get_attachment_image( $post_image_id, $size, false, $attr ) . '</a>';
	
	return $html;
}, 10, 5);