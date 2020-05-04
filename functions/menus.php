<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Menus Functions
 *
 * @package Anonymous theme
 * @author Makiomar
 * @link http://makiomar.com
 */

$anonyOptions = anonyOpt();
/*-------------------------------------------------------------
 * Menus functions
 *-----------------------------------------------------------*/

/**
 * Gets navigation menu.
 *
 * **Description: ** If the location of main-menu has menu, it will use wp_nav_menu else,
 * it will use wp_list_pages, and it will apply a custom walker only if main-menu location.
 *
 * **Note: ** This is to keep the main navigation always has items
 * @param string $location_slug The slug of manu
 * @param string $container The HTML container of manu
 * @return string Menu list
 */
function anony_navigation($location_slug, $container = 'nav'){
	$container_id = 'anony-main_nav_con';
	
	if ($location_slug == 'anony-main-menu'){
		$walker       = new ANONY_Nav_Menu_Walk;
		$container_id = 'anony-main_nav_con';
	}
	
	$menu_id = $location_slug . '-con';
	
	
	if ( has_nav_menu( $location_slug ) ) {
		$location_array = explode('-',$location_slug);
			$args = array (
					'theme_location'=> $location_slug,
					'depth'         => 0,
					'menu_id'       => $menu_id,
					'container'     => $container,
					'container_id'  => $container_id,
					'echo' => false,
					);
			if(isset($walker)){
				$args['walker'] = $walker;
			}
			return wp_nav_menu($args);
	}else{
		if($location_slug == 'anony-main-menu'){
			$page_for_posts = get_option( 'page_for_posts' );
			$args = array (
				'title_li'=>0,
				'depth'=>3,
				'echo' => false,
				'include' => array($page_for_posts),
			);
			$menu = '<nav id="anony-main_nav_con"><ul id="anony-main-menu-con">'.wp_list_pages($args).'</ul></nav>';
			return $menu;
		}
	 }
}


/**
 * Generates anony-breadcrumbs menu
 *
 * **Description: ** Echoes out the breadcrumps menu
 * @return void
 */
function anony_breadcrumbs() {
	global $post;
	$homeLink = home_url();
	echo '<ul class="anony-breadcrumbs">';
	echo '<li class="home"><i class="fa fa-home"></i> <a href="'. $homeLink .'">'. esc_html__('Home',ANONY_TEXTDOM) .'</a> <span>/</span></li>';

	// Blog Category
	if ( is_category() ) {
		//echo '<li><a href="'. anony_get_curr_url() .'">'. single_cat_title('', false) . '</a></li>';
				wp_reset_query();
				$incurr_category = get_category(get_query_var('cat'));
				$incurr_category_id = $incurr_category ->cat_ID;
				echo '<li class="parent-categories">';
				echo get_category_parents( $incurr_category_id, true, ' / ');
				echo '</li>';

	// Blog Day
	} elseif ( is_day() ) {
		echo '<li><a href="'. get_year_link(get_the_time('Y')) . '">'. get_the_time('Y') .'</a> <span>/</span></li>';
		echo '<li><a href="'. get_month_link(get_the_time('Y'),get_the_time('m')) .'">'. get_the_time('F') .'</a> <span>/</span></li>';
		echo '<li><a href="'. anony_get_curr_url() .'">'. get_the_time('d') .'</a></li>';

	// Blog Month
	} elseif ( is_month() ) {
		echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> <span>/</span></li>';
		echo '<li><a href="'. anony_get_curr_url() .'">'. get_the_time('F') .'</a></li>';

	// Blog Year
	} elseif ( is_year() ) {
		echo '<li><a href="'. anony_get_curr_url() .'">'. get_the_time('Y') .'</a></li>';

	// Single Post
	} elseif ( is_single() && !is_attachment() ) {

		// Custom post type
		if ( get_post_type() != 'post' ) {
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;

		// Blog post
		} else {
			$cat = get_the_category();
			$cat = $cat[0];
			echo '<li>';
				echo get_category_parents($cat, TRUE, ' <span>/</span>');
			echo '</li>';
			echo '<li><a href="' . anony_get_curr_url() . '">'. wp_title( '',false ) .'</a></li>';
		}

	// Taxonomy
	} elseif( get_post_taxonomies() ) {

		

	// Page with parent
	} elseif ( is_page() && $post->post_parent ) {
		$parent_id  = $post->post_parent;
		$breadcrumbs = array();
		while ($parent_id) {
			$page = get_page($parent_id);
			$breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a> <span>/</span></li>';
			$parent_id  = $page->post_parent;
		}
		$breadcrumbs = array_reverse($breadcrumbs);
		foreach ($breadcrumbs as $crumb) echo $crumb;

		echo '<li><a href="' . anony_get_curr_url() . '">'. get_the_title() .'</a></li>';

	// Default
	} elseif(get_the_title()!= 'Home'){
		echo '<li><a href="' . anony_get_curr_url() . '">'. get_the_title() .'</a></li>';
	}

	echo '</ul>';
}

/*-------------------------------------------------------------
 * Menus hooks
 *-----------------------------------------------------------*/
//Add Close button to main navigation menu
add_filter("wp_nav_menu_items",function($item , $args){
	
	if($args->theme_location == 'anony-main-menu'){
		$item .= '<li id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></li>';
		return $item;
	}else{
		return $item;
	}
	
},10 , 2);

//Register theme menus
add_action( 'after_setup_theme', function() {
	
	$menus= array(
		'anony-main-menu'     => esc_html__('Main menu. Shows on the main navigation',ANONY_TEXTDOM),
		'anonyfooter-menu'    => esc_html__('Footer menu. Shows on the footer',ANONY_TEXTDOM),
		'anony-languages-menu'=> esc_html__('Languages menu. Shows on the top header',ANONY_TEXTDOM),
		'anony-user-menu'     => esc_html__('Users menu. Shows on the top header',ANONY_TEXTDOM),
	); 
	
	foreach($menus as $name => $description){
		register_nav_menu($name, $description);
	}
} );


//Adds active class to the currently active menu item
add_filter('nav_menu_css_class' , function($classes, $item) {
	
    if (in_array('current-menu-item', $classes)){
        $classes[] = 'active ';
    }
    return $classes;
} , 10 , 2);

//Add Adds categories menu to the main navigation menu,(Show only if on mobile device).
if(anonyGetOpt($anonyOptions, 'cats_in_nav') != '0'){
	add_filter("wp_nav_menu_items",function($item , $args){
		if($args->theme_location == 'main-menu'){
			$item.='<li><ul id="anony-cat-list" class="anony-cat-list">';
				$args = array(
						'hide_empty' => 0,
						'title_li' => '',
						'order'=> 'DESC',
						'echo' => false,
						'walker' => new ANONY_Cats_Walk()
					   );
			$item.= wp_list_categories($args);
			$item.='</ul></li>';
			return $item;

		}else{
			return $item;
		}
	},10 , 2);
}

//Add search form to main menu
add_filter("wp_nav_menu_items",function($item , $args){
	if($args->theme_location == 'anony-main-menu' && (!is_front_page() || !is_page())){
		$item.='<li class="anony-search-form-toggle active"><a href="#"><i class="fa fa-search"></i></a></li>';
		return $item;
	}else{
		return $item;
	}
},10 , 2);

//Adds WPML language switcher to languages-menu location
add_filter("wp_nav_menu_items",function($item , $args){
	$pluginList = get_option( 'active_plugins' );
	$wpml_plugin = 'sitepress-multilingual-cms/sitepress.php';
	if ( in_array( $wpml_plugin , $pluginList ) && $args->theme_location == 'anony-languages-menu' ) {
		$languages = icl_get_languages('skip_missing=0');
		if(!empty($languages)){
			foreach($languages as $l){
				if($l['language_code'] == ICL_LANGUAGE_CODE){
					$curr_lang = $l;
				}
				$item .='<li class="anony-lang">';
				$item .= '<a class="lang-item '.ANONY_WPML_HELP::ActiveLangClass($l['language_code']).'" href="'.$l['url'].'">';
				$item .= icl_disp_language(strtoupper($l['language_code']));
				$item .='</a>';
				$item .='</li>';
			}
			$item .= '<li id="anony-lang-toggle"><img src="'.$curr_lang['country_flag_url'].'" width="32" height="20" alt="'.$l['language_code'].'"/></li>';
		}
		return $item;
	}else{
		return $item;
	}
},10 , 2);

//Adds the active class to menu item of current active page
add_filter('page_css_class' , function ($css_class, $page, $depth, $args, $current_page) {
    if (in_array('current_page_item', $css_class)){
        $css_class[] = 'active ';
    }
    return $css_class;
} , 10 , 5);

//add a menu item for homepage to pages menu
add_filter('wp_list_pages',function($output, $r, $pages){
 $home = '<li><a href="'.get_home_url().'">'.__('<i class="fa fa-home"></i>',ANONY_TEXTDOM).'</a></li>';
 $output = $home.$output;
        return $output;
},10,3);
?>