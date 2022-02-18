<?php
if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}

/**
 * Featured posts template
 *
 * @package Anonymous theme
 * @author  Makiomar
 * @link    http://makiomar.com
 */


$anony_options = ANONY_Options_Model::get_instance();

$slider_settings = [
    
    'style' => 'one',
    'show_read_more' => false,
    'show_pagination' => true,
    'pagination_type' => 'dots', //Accepts (thumbnails or dots)
    'slider_data' => [ 'transition' => 5000, 'animation' => 1500 ],
];

$message = '';

$args = array(
            'posts_per_page' => 5,
            'order'          => 'ASC',
            'meta_query'     => [
                                    [
                                     'key' => '_thumbnail_id',
                                     'compare' => 'EXISTS'
                                    ],
                                ]
        );

        
if($anony_options->slider_content == 'featured-cat' && $anony_options->featured_cat != '0') {
    
    $FreaturedCat = get_term_by( 
        'id', 
        $anony_options->featured_cat,
        $anony_options->featured_tax
    );

    if($FreaturedCat) {
        $args['cat'] = $FreaturedCat->term_id;
    }else{
        $message = esc_html__('Please make sure you select a category and its corresponding taxonomy from theme options->slider', ANONY_TEXTDOM);
    }

}elseif($anony_options->slider_content == 'featured-post') {
    $args['meta_key'] = 'anony__set_as_featured';
}    


$query = new WP_Query($args);

$data = [];

if ($query->have_posts()) {
    
    while($query->have_posts()) {
        $query->the_post();
        if (has_post_thumbnail() && get_the_post_thumbnail_url()) {
            
            $temp = anony_common_post_data();    
            
            if ($temp['thumb_exists']) {
                $data[] = $temp;
            }
            
        }
        
    }
    
    wp_reset_postdata();
}

if(empty($data)) {
    $message = esc_html__('Sorry! but we can\'t find any post with available thumbnail to show in slider', ANONY_TEXTDOM);
}

$count = count($data);

extract($slider_settings);

if($show_pagination) {
    
    $slider_nav = [];
    
    foreach($data as $index => $p) : 
    
        extract($p);

        $slider_nav_temp['permalink'] = $permalink;
        $slider_nav_temp['id'] = $id;
        $slider_nav_temp['title']     = $title;
        $slider_nav_temp['class']     = $index == 0 ?  'anony-active-slide ': '';
        $slider_nav_temp['thumbnail_img']     = $thumbnail_img;

        $slider_nav[] = $slider_nav_temp;

    endforeach;
}


$title_link = isset($args['cat']) ? get_category_link($args['cat']) : '#';

$title_text = isset($args['cat']) ? get_cat_name($args['cat']) : esc_html__('Featured Posts', ANONY_TEXTDOM);



require locate_template('templates/featured-'.$style.'.view.php', false, false);

wp_enqueue_script('anony-featured-slider');
    
?>
    