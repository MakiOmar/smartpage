<?php
//menus
add_action( 'after_setup_theme', 'register_smartpage_menu' );
function register_smartpage_menu() {
	$menus= array(
		'main-menu'=> esc_html__('Shows on the main navigation',TEXTDOM),
		'footer-menu'=>__('Shows on the footer',TEXTDOM),
		'languages-menu'=>__('Shows on the top header',TEXTDOM),
	); 
	foreach($menus as $name => $description){
		register_nav_menu($name, $description);
	}
}


function smpg_main_navigation($location_slug, $container = 'nav'){
	if ($location_slug == 'main-menu'){
		$walker = new Smpg__Nav_Menu_Walk;
	}
	if ( has_nav_menu( $location_slug ) ) {
		$location_array = explode('-',$location_slug);
			$args = array (
					'theme_location'=>$location_slug,
					'depth'=>0,
					'menu_id' =>$location_array[0].'_menu_con',
					'container' =>$container,
					'container_id' =>$location_array[0].'_nav_con',
					'echo' => false,
					);
			if(isset($walker)){
				$args['walker'] = $walker;
			}
			return wp_nav_menu($args);
	}else{
		if($location_slug == 'main-menu'){
			$page_for_posts = get_option( 'page_for_posts' );
			$args = array (
				'title_li'=>0,
				'depth'=>3,
				'echo' => false,
				'include' => array($page_for_posts),
			);
			$menu = '<nav id="main_nav_con"><ul id="main_menu_con">'.wp_list_pages($args).'</ul></nav>';
			return $menu;
		}
	 }
}
//Add Close button to main navigation menu
add_filter("wp_nav_menu_items","main_nav_close_button",10 , 3);
function main_nav_close_button($item , $args){
	if($args->theme_location == 'main-menu'){
		$item .= '<li id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></li>';
		return $item;
	}else{
		return $item;
	}
}


//Check active menu item
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes)){
        $classes[] = 'active ';
    }
    return $classes;
}

function active_language($lang){
	global $sitepress;
	$pluginList = get_option( 'active_plugins' );
	$wpml_plugin = 'wpml-translation-management/plugin.php';
	if ( in_array( $wpml_plugin , $pluginList ) ) {
		if($lang == ICL_LANGUAGE_CODE){
			return 'active-lang';
		}
	}
	return;
}

if(opt_init_()->cats_in_nav != '0'){
	add_filter("wp_nav_menu_items","add_cats_menu",10 , 3);
}

/*
*Add Adds categories menu to the main navigation menu
*(Show only if on mobile device)
*/

function add_cats_menu($item , $args){
	if($args->theme_location == 'main-menu'){
	$item.='<li><ul id="smpg-cat-list" class="smpg-cat-list">';
		$args = array(
				'hide_empty' => 0,
				'title_li' => '',
				'order'=> 'DESC',
				'echo' => false,
				'walker' => new Smpg__Cats_Walk()
			   );
	$item.= wp_list_categories($args);
	$item.='</ul></li>';
	/*$item .= '<li id="menu-close"><a href="#"><i class="fa fa-2x fa-window-close" aria-hidden="true"></i></a></li>';*/
	return $item;
	}else{
		return $item;
	}
}

//Add search form to main menu
add_filter("wp_nav_menu_items","add_search_form",10 , 2);
function add_search_form($item , $args){
	if($args->theme_location == 'main-menu' && !is_front_page() && !is_page()){
		$item.='<li class="search-form-toggle active"><a href="#"><i class="fa fa-search"></i></a></li>';
		return $item;
	}else{
		return $item;
	}
}

add_filter("wp_nav_menu_items","add_language_menu",10 , 2);
//WPML compatible menu
function add_language_menu($item , $args){
	$pluginList = get_option( 'active_plugins' );
	$wpml_plugin = 'sitepress-multilingual-cms/sitepress.php';
	if ( in_array( $wpml_plugin , $pluginList ) && $args->theme_location == 'languages-menu' ) {
		$languages = icl_get_languages('skip_missing=0');
		if(!empty($languages)){
			foreach($languages as $l){
				if($l['language_code'] == ICL_LANGUAGE_CODE){
					$curr_lang = $l;
				}
				$item .='<li class="lang">';
				$item .= '<a class="'.active_language($l['language_code']).'" href="'.$l['url'].'">';
				$item .= icl_disp_language(strtoupper($l['language_code']));
				$item .='</a>';
				$item .='</li>';
			}
			$item .= '<li id="lang-toggle"><img src="'.$curr_lang['country_flag_url'].'" width="32" height="20" alt="'.$l['language_code'].'"/></li>';
		}
		return $item;
	}else{
		return $item;
	}
}

add_filter('page_css_class' , 'special_page_menu_class' , 10 , 5);
function special_page_menu_class ($css_class, $page, $depth, $args, $current_page) {
    if (in_array('current_page_item', $css_class)){
        $css_class[] = 'active ';
    }
    return $css_class;
}//add homepage to pages list
add_filter('wp_list_pages','add_home_to',10,3);

function add_home_to($output, $r, $pages){
 $home = '<li><a href="'.get_home_url().'">'.__('<i class="fa fa-home"></i>',TEXTDOM).'</a></li>';
 $output = $home.$output;
        return $output;
}
/* ---------------------------------------------------------------------------
 * Breadcrumbs
 * --------------------------------------------------------------------------- */
function smpg_breadcrumbs() {
	global $post;
	$homeLink = home_url();
	echo '<ul class="breadcrumbs">';
	echo '<li class="home"><i class="fa fa-home"></i> <a href="'. $homeLink .'">'. esc_html__('Home',TEXTDOM) .'</a> <span>/</span></li>';

	// Blog Category
	if ( is_category() ) {
		//echo '<li><a href="'. curPageURL() .'">'. single_cat_title('', false) . '</a></li>';
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
		echo '<li><a href="'. curPageURL() .'">'. get_the_time('d') .'</a></li>';

	// Blog Month
	} elseif ( is_month() ) {
		echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> <span>/</span></li>';
		echo '<li><a href="'. curPageURL() .'">'. get_the_time('F') .'</a></li>';

	// Blog Year
	} elseif ( is_year() ) {
		echo '<li><a href="'. curPageURL() .'">'. get_the_time('Y') .'</a></li>';

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
			echo '<li><a href="' . curPageURL() . '">'. wp_title( '',false ) .'</a></li>';
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

		echo '<li><a href="' . curPageURL() . '">'. get_the_title() .'</a></li>';

	// Default
	} elseif(get_the_title()!= 'Home'){
		echo '<li><a href="' . curPageURL() . '">'. get_the_title() .'</a></li>';
	}

	echo '</ul>';
}
?>