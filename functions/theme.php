<?php
/**
 * Theme Functions
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

/*-------------------------------------------------------------
 * Theme hooks
 *-----------------------------------------------------------*/
//Load Text Domain
add_action('after_setup_theme', function(){
	load_theme_textdomain(ANONY_TEXTDOM, ANONY_LANG_DIR);
});

add_action('wp_ajax_anoe_dynamic_css', 'anoe_dynamic_css');
add_action('wp_ajax_nopriv_anoe_dynamic_css', 'anoe_dynamic_css');
function anoe_dynamic_css() {
	require( ANONY_THEME_DIR . '/assets/css/dynamic.php' );
	exit;
}

//Theme Scripts
add_action('wp_enqueue_scripts',function() {
		
$anonyOptions = anonyOpt();

		$styles = array('main','font-awesome','responsive','prettyPhoto');
		foreach($styles as $style){
			wp_enqueue_style( $style , get_theme_file_uri('/assets/css/'.$style.'.css') , false, filemtime(wp_normalize_path(get_theme_file_path('/assets/css/'.$style.'.css'))) );
		}
		if(is_rtl()){
			wp_enqueue_style( 'rtl' , get_theme_file_uri('/assets/css/rtl.css') ,array('main'), filemtime(wp_normalize_path(get_theme_file_path('/assets/css/rtl.css'))));
		}

		$dynamic_deps = ['main'];
		
		if(anonyGetOpt($anonyOptions, 'color_skin') !== 'custom' && !empty(anonyGetOpt($anonyOptions, 'color_skin'))){

			$skin = anonyGetOpt($anonyOptions, 'color_skin');

			$dynamic_deps = [$skin.'-skin'];

			wp_enqueue_style( $skin.'-skin' , get_theme_file_uri('/assets/css/skins/'.$skin.'.css') ,array('main'), filemtime(wp_normalize_path(get_theme_file_path('/assets/css/skins/'.$skin.'.css'))));
		}

		wp_enqueue_style( 'anonyengine-dynamics', admin_url('admin-ajax.php').'?action=anoe_dynamic_css', $dynamic_deps);

		//wp_enqueue_style( 'anonyengine-dynamics', ANONY_THEME_DIR . '/assets/css/dynamic.php', $dynamic_deps );

		if(is_single()){
			$scripts = array('jquery.validate.min', 'ajax_comment');
			foreach($scripts as $script){
				wp_register_script( $script , get_theme_file_uri('/assets/js/'.$script.'.js') ,array('jquery'),filemtime(wp_normalize_path(get_theme_file_path('/assets/js/'.$script.'.js'))),true);
				wp_enqueue_script($script);
			}
		}

		$scripts = array('jquery.prettyPhoto','custom');

		if(is_home() || is_front_page()){
			$scripts = array_merge($scripts, array('jquery.mousewheel','jquery.easing.1.3','jquery.contentcarousel'));
		}
			foreach($scripts as $script){
				wp_register_script( $script , get_theme_file_uri('/assets/js/'.$script.'.js') ,array('jquery'),filemtime(wp_normalize_path(get_theme_file_path('/assets/js/'.$script.'.js'))),true);
				wp_enqueue_script($script);
			}

		// Localize the script with new data
		$anony_loca = array(
			'ajaxURL'         => ANONY_WPML_HELP::getAjaxUrl(),
			'textDir'         => (is_rtl() ? 'rtl' : 'ltr'),
			'themeLang'       => get_bloginfo('language'),
			'anonyFormAuthor'  => esc_html__("Please enter a valid name", ANONY_TEXTDOM),
			'anonyFormEmail'   => esc_html__("Please enter a valid email", ANONY_TEXTDOM),
			'anonyFormUrl'     => esc_html__("Please use a valid website address", ANONY_TEXTDOM),
			'anonyFormComment' => esc_html__("Comment must be at least 20 characters", ANONY_TEXTDOM),
		);
		wp_localize_script( 'custom', 'SmpgLoca', $anony_loca );
	});

//Add theme support
add_action( 'after_setup_theme', function() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background');
	add_theme_support( 'post-thumbnails', array( 'post','anony_download' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'post-formats', array( 'gallery', 'quote', 'video', 'aside', 'image', 'link' ) );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
}, 20 );

//Register Sidebars
add_action('widgets_init',function(){
	$sidebars = array('Right Sidebar','left Sidebar','Secondary Sidebar','Footer Widget 1','Footer Widget 2','Footer Widget 3','Footer Widget 4');
	foreach($sidebars as $sidebar){
	    $sidebar_id = strtolower(str_replace(' ','-',$sidebar ));
	    $args = array(
			'name'=> esc_html__( $sidebar, ANONY_TEXTDOM ),
			'id'=> $sidebar_id,
			'class'=>$sidebar_id,
			'before_widget' => '<div class="widgeted anony-grid-col-md-6 anony-grid-col-av-6 anony-grid-col-sm-12 anony-grid-col">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgeted_title">',
			'after_title'   => '</h3>' 
	    );
	   register_sidebar( $args );
	}
});

//Remove width|height from img
add_filter( 'post_thumbnail_html', function ( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}, 10, 5 );

//Remove type attribute from styles.
add_filter('style_loader_tag', 'anony_remove_type_attr', 10, 2);

//Remove type attribute from scripts.
add_filter('script_loader_tag', 'anony_remove_type_attr', 10, 2);

/*-------------------------------------------------------------
 * Theme hooks
 *-----------------------------------------------------------*/
/**
 * Get current page url.
 *
 * **Description: ** Gets current page url and takes in account the ssl also port 80.
 *
 * @return string
 */
function anony_get_curr_url() {
	$pageURL = 'http';
	if ( key_exists("HTTPS", $_SERVER) && ( $_SERVER["HTTPS"] == "on" ) ){
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

/**
 * Generates logo markup.
 *
 * **Description: ** If logo is set from customizer it will display it.
 * otherwise it will display a default theme logo.<br/>
 * **Note: ** can be overriden by hookin on anony_get_custom_logo.
 *
 * @param string $color The color of theme's default logo,
 * Will have no effect once a logo is set from customizer.
 * @return string Theme's logo with a link to the homepage
 */
function anony_get_custom_logo($color='main') {	
	if ( has_custom_logo() ) {
		$logo ='<div id="anony-logo" class="anony-grid-col-md-4 anony-grid-col-sm-3">'.get_custom_logo().'</div>';	
	}else{

		$logo= '<div id="anony-logo" class="anony-grid-col-md-4 anony-grid-col-sm-3"><h1>';
		$logo .='<a href="'.ANONY_BLOG_URL.'" title="'.ANONY_BLOG_TITLE.'">';
		$logo .='<img alt="'.ANONY_BLOG_TITLE.'" '; 
		$logo .= 'src="'.ANONY_THEME_URI.'/images/logo-'.$color.'.png"/>';
		$logo .='</a></h1></div>';
	}
	return apply_filters('anony_get_custom_logo', $logo);

}

/**
 * Remove type attribute from styles/scripts.
 *
 * **Description: ** It is recommended to remove type attribute from styles/scripts that ahs a link|src attribute.
 * @param $tag string style|script tag
 * @param $handle string style|script handle defined with wp_register_style|wp_register_script
 * @return string styles/scripts tags with no type attribute.
 */
function anony_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

/**
 * Generates comments number markup.
 *
 * @return string HTML of comments number.
 */
function anony_comments_number() {
	$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
	
	if ( comments_open() ) {
		if ( $num_comments != 1 ) {
			$comments = '<a class="meta-text" href="' . get_comments_link() .'"> '. $num_comments.'</a><span class="meta-text single-meta-text">&nbsp;'.esc_html__('comments',ANONY_TEXTDOM).'&nbsp;</span>';
		} else {
			$comments = '<a class="meta-text" href="' . get_comments_link() .'"> 1 </a><span class="meta-text single-meta-text">&nbsp;'.esc_html__('comment',ANONY_TEXTDOM).'&nbsp;</span>';
		}
	} else {
		$comments = '<span class="meta-text single-meta-text">'.esc_html__('Comments-off',ANONY_TEXTDOM).'</span>';
	}
	return $comments;
}
?>