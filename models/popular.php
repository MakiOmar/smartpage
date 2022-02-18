<?php
if (! defined('ABSPATH') ) {
    exit; // Exit if accessed direct.ly
}

$query = new WP_Query(
    [
            //NO. of posts you want to show 
            'posts_per_page' => 4,
            'meta_key' => 'post_views_count',
            // Order according to numbers not name 
            'orderby'=> 'meta_value_num',
            'order' => 'DESC', 
        ]
);

$data = [];

//Check if VC shortcode hasn't sent hide thumb flag
if(!isset($hide_thumb)) {
    
    //By default
    $hide_thumb =  false;
    
}

//Check if VC shortcode hasn't sent hide date flag
if(!isset($hide_date)) {
    
    //By default
    $hide_date =  false;
    
}

//Check if VC shortcode hasn't sent hide views flag
if(!isset($hide_views)) {
    
    //By default
    $hide_views =  false;
    
}

//Check if VC shortcode hasn't sent hide rating flag
if(!isset($hide_rating)) {
    
    //By default
    $hide_rating =  false;
    
}

//Check if VC shortcode hasn't sent hide most popular flag
if(!isset($hide_most_popular)) {
    
    //By default
    $hide_most_popular =  false;
    
}

//Check if VC shortcode hasn't sent hide recent comments flag
if(!isset($hide_recent_comments)) {
    
    //By default
    $hide_recent_comments =  false;
    
}



if ($query->have_posts()) {
    
    while($query->have_posts()) {
        $query->the_post();
        
        $temp = anony_common_post_data();
        
        $temp['thumb_img'] = get_the_post_thumbnail(get_the_ID(), 'popular-post-thumb', array( 'class' => 'post-thumb'));
        
        $data[] = $temp;
        
    }
    
    wp_reset_postdata();
}
if (empty($data)) {
    
    
    esc_html_e('No popular posts', $domain = 'default');
    
    return;
}

wp_enqueue_script('anony-tabs');

require locate_template('templates/popular.view.php', false, false);
?>
