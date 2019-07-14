<?php
function curPageURL() {
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
//Load Text Domain
add_action('after_setup_theme', 'smartpage_theme_textdomain');

function smartpage_theme_textdomain(){
	load_theme_textdomain(TEXTDOM, get_template_directory().'/languages');
}

//Theme Scripts
add_action('wp_enqueue_scripts','smartpage_enqueue_styles');

function smartpage_enqueue_styles() {
	$smpgOptions = Smpg__Options_Model::get_instance();

	$styles = array('main','font-awesome','responsive','prettyPhoto');
	foreach($styles as $style){
		wp_enqueue_style( $style , get_theme_file_uri('/assets/css/'.$style.'.css') , false, filemtime(wp_normalize_path(get_theme_file_path('/assets/css/'.$style.'.css'))) );
	}
	if(is_rtl()){
		wp_enqueue_style( 'rtl' , get_theme_file_uri('/assets/css/rtl.css') ,array('main'), filemtime(wp_normalize_path(get_theme_file_path('/assets/css/rtl.css'))));
	}
	
	if($smpgOptions->color_skin !== 'custom' /*&& !empty($smpgOptions->color_skin)*/){
		wp_enqueue_style( $smpgOptions->color_skin.'-skin' , get_theme_file_uri('/assets/css/skins/'.$smpgOptions->color_skin.'.css') ,array('main'), filemtime(wp_normalize_path(get_theme_file_path('/assets/css/skins/'.$smpgOptions->color_skin.'.css'))));
	}
	
	if(is_single()){
		$scripts = array('jquery.validate.min', 'ajax_comment');
		foreach($scripts as $script){
			wp_register_script( $script , get_theme_file_uri('/assets/js/'.$script.'.js') ,array('jquery'),filemtime(wp_normalize_path(get_theme_file_path('/assets/js/'.$script.'.js'))),true);
			wp_enqueue_script($script);
		}
	}
	
	$scripts = array('jquery.mousewheel','jquery.easing.1.3','jquery.contentcarousel','jquery.prettyPhoto','custom');
		foreach($scripts as $script){
			wp_register_script( $script , get_theme_file_uri('/assets/js/'.$script.'.js') ,array('jquery'),filemtime(wp_normalize_path(get_theme_file_path('/assets/js/'.$script.'.js'))),true);
			wp_enqueue_script($script);
		}
	
	// Localize the script with new data
	$smpg_loca = array(
		'ajaxURL'         => smpg_get_ajax_url(),
		'textDir'         => (is_rtl() ? 'rtl' : 'ltr'),
		'themeLang'       => get_bloginfo('language'),
		'smpgFormAuthor'  => esc_html__("Please enter a valid name", TEXTDOM),
		'smpgFormEmail'   => esc_html__("Please enter a valid email", TEXTDOM),
		'smpgFormUrl'     => esc_html__("Please use a valid website address", TEXTDOM),
		'smpgFormComment' => esc_html__("Comment must be at least 20 characters", TEXTDOM),
	);
	wp_localize_script( 'custom', 'SmpgLoca', $smpg_loca );

	
}

//Add theme support
function supp_theme_features() {
add_theme_support( 'title-tag' );
add_theme_support( 'custom-logo' );
add_theme_support( 'custom-header' );
add_theme_support( 'custom-background');
add_theme_support( 'post-thumbnails', array( 'post','smpg_download' ) );
add_theme_support( 'customize-selective-refresh-widgets' );
add_theme_support( 'post-formats', array( 'gallery', 'quote', 'video', 'aside', 'image', 'link' ) );
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'supp_theme_features', 20 );

//Sidebars
add_action('widgets_init','smp_main_sidebar');
function smp_main_sidebar(){
	$sidebars = array('Right Sidebar','left Sidebar','Secondary Sidebar','Footer Widget 1','Footer Widget 2','Footer Widget 3','Footer Widget 4');
	foreach($sidebars as $sidebar){
	    $sidebar_id = strtolower(str_replace(' ','-',$sidebar ));
	    $args = array(
			'name'=> esc_html__( $sidebar, TEXTDOM ),
			'id'=> $sidebar_id,
			'class'=>$sidebar_id,
			'before_widget' => '<div class="widgeted grid-col-md-6 grid-col-av-6 grid-col-sm-12 grid-col">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgeted_title">',
			'after_title'   => '</h3>' 
	    );
	   register_sidebar( $args );
	}
}



//custom logo
function smartpage_custom_logo($color='main') {	
	if ( has_custom_logo() ) {
		$logo ='<id="logo" class="grid-col-md-4 grid-col-sm-3">'.get_custom_logo().'</div>';	
	}else{
		$logo= '<div id="logo" class="grid-col-md-4 grid-col-sm-3"><h1>';
		$logo .='<a href="'.get_bloginfo('url').'" title="'.get_bloginfo('name').'">';
		$logo .='<img alt="'.get_bloginfo('name').'" '; 
		$logo .= 'src="'.get_theme_file_uri().'/images/logo-'.$color.'.png"/>';
		$logo .='</a></h1></div>';
	}
	return $logo;

}

/*For wordpress 's default login page*/
// custom login logo tooltip
add_filter('login_headertitle', 'change_title_on_logo');
function change_title_on_logo() {
	return get_bloginfo();
}

// custom login logo link
add_filter('login_headerurl','loginpage_custom_link');
function loginpage_custom_link() {
	return get_bloginfo('url');
}
/*=============================*/

function rand_custom_colors(){
	$colors = array('#861618','#3568E1','#f33806','#CF2629');
	$rand_color= array_rand($colors);
	return $colors[$rand_color];
}

add_filter( 'post_thumbnail_html', 'remove_thumbnail_width_height', 10, 5 );
 
function remove_thumbnail_width_height( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
add_filter('style_loader_tag', 'smpg_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'smpg_remove_type_attr', 10, 2);

function smpg_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

/* ---------------------------------------------------------------------------
 *	Comments number with text
 * --------------------------------------------------------------------------- */
function smpg_comments_number() {
	$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
	
	if ( comments_open() ) {
		if ( $num_comments != 1 ) {
			$comments = '<a class="meta-text" href="' . get_comments_link() .'"> '. $num_comments.'</a><span class="meta-text single-meta-text">&nbsp;'.__('comments',TEXTDOM).'&nbsp;</span>';
		} else {
			$comments = '<a class="meta-text" href="' . get_comments_link() .'"> 1 </a><span class="meta-text single-meta-text">&nbsp;'.__('comment',TEXTDOM).'&nbsp;</span>';
		}
	} else {
		$comments = '<span class="meta-text single-meta-text">'.__('Comments-off',TEXTDOM).'</span>';
	}
	return $comments;
}

//Check if plugin wpml is activated
function is_wpml_active(){
	$pluginList = get_option( 'active_plugins' );
	
	$wpml_plugin = 'sitepress-multilingual-cms/sitepress.php';
	
	if ( in_array( $wpml_plugin , $pluginList ) ) {
		
		return true;
		
	}elseif(function_exists('icl_object_id')){
		
		return true;
		
	}
	return false;
}

/*
*Get the AJAX url with wpml if plugin is active
*/
function smpg_get_ajax_url(){
	$ajax_url = admin_url( 'admin-ajax.php' );

	if(is_wpml_active()){

		$wpml_active_lang = apply_filters('wpml_current_language',NULL);

		if($wpml_active_lang){

			$ajax_url = add_query_arg('wp_lang',$wpml_active_lang, $ajax_url);
			

		}

	}
	
	return $ajax_url;
}
?>