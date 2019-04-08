<?php
define( 'THEME_DIR', wp_normalize_path( get_template_directory() ) );

define( 'THEME_URI', get_template_directory_uri() );

define( 'THEME_NAME', 'Smartpage' );

define( 'TEXTDOM', strtolower(THEME_NAME) );

define( 'THEME_VERSION', '1.0' );

define( 'LIBS_DIR', THEME_DIR . '/functions/' );

define( 'LANG_DIR', THEME_DIR. '/languages/' );

define( 'STAR_RATE', $GLOBALS['wpdb']->prefix . 'star_rating' );


define('SuppTypes',serialize(array('pdf','doc','docx','7z','arj','deb','zip','iso','pkg','rar','rpm','z','gz','bin','dmg','toast','vcd','csv','dat','log','mdb','sav','tar','ods','xlr','xls','xlsx','odt','txt','rtf','tex','wks','wps','wpd')));


/*
*Classes Auto loader
*/
spl_autoload_register( 'smpg_autoloader' );

/*
*@param  string $class_name 
*/
function smpg_autoloader( $class_name ) {
	
  if ( false !== strpos( $class_name, 'Smpg' ) ) {
	  
    $classes_dir = THEME_DIR .'/functions/smpg-classes/';
	  
    $class_file = 'class-' . str_replace( '_', '-',strtolower($class_name)  ) . '.php';
	  
    require_once $classes_dir . $class_file;
	  
  }
	
}

$smpglibs = [
	'posts-functions'     =>'',
	'theme-functions'     =>'',
	'menus-functions'     =>'',
	'admin-functions'     =>'',
	'media-functions'     =>'',
	'db-functions'        =>'',
	'php-helpers'         =>'helper/',
	'wordpress-helpers'   =>'helper/',
	'ajax-comments'       =>'ajax/',
	
];

foreach($smpglibs as $smpglib=>$path){
	require_once(LIBS_DIR.$path.$smpglib.'.php');
}

add_action('wp_footer', function(){
	//test
});

/*
*Get lates comments
*/
function latest_comments(){
	
	$args = array('number'=>4,'author__not_in' => array(get_current_user_id()));
	
		$comments = get_comments($args);
	
		if(count($comments) > 0){
			
			foreach($comments as $comment) {?>	
			
				<div  class="recent-comment-wrapper">
				
					<h3><?php echo '<i class="fa fa-user"></i> '.$comment->comment_author.' '.__('Commented',TEXTDOM) ?></h3>
					
					<p class='recent-comment'>
					<?php echo substr($comment->comment_content,0 , 150).'... ' ?>
					
					<a href="<?php echo get_the_permalink($comment->comment_post_ID)?>"><?php _e('View Post',TEXTDOM) ?></a>
					
					</p>
					
				</div>
				
		<?php }}else{?>
				
					<p><?php _e('No comments yet',TEXTDOM);?></p>
					
				<?php };
}

/*
*Changes rhe default role of registered user
*Shloud be checked befoor publish
*/
add_filter('pre_option_default_role', function($default_role){
	
    // You can also add conditional tags here and return whatever
    return 'administrator'; // This is changed
	
    return $default_role; // This allows default
	
});


/*
*Controles the registration link on wp-login.php
*Shloud be checked befoor publish
*/
add_filter('option_users_can_register', function($value) {
    
        $value = true;
    
    return $value;
});

/*
*define post types to search for
*/
add_filter('pre_get_posts','searchFilter');

function searchFilter($query) {
 
    if ($query->is_search && !is_admin() ) {
		
        $query->set('post_type',array('post','page'));
		
    }
 
	return $query;
}

/*
*Register categories widget
*/
add_action('widgets_init', 'smpg_cats_widget_register');

function smpg_cats_widget_register(){
	
	register_widget('Smpg_Cats_Widget');
	
}