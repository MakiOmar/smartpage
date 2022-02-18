<?php
if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}

$args = ['posts_per_page' => 4];

$recent = new WP_Query($args);

$data = [];

if ($recent->have_posts() ) {
    while ($recent->have_posts() ) { 
        $recent->the_post(); 

        $temp['id']        = get_the_ID();
        $temp['permalink'] = esc_url(get_the_permalink());
        $temp['title']     = esc_html(get_the_title());
        $temp['no_posts']  = esc_html__('No published posts', 'smartpage');
        $temp['meta']      = 
        [
        'calender' => esc_html(get_the_date('Y-m-d')),
        'eye'      => esc_html(anony_get_post_views(get_the_ID())),
        'comment'  => comments_number( 
            esc_html__('No comments', 'smartpage'),
            esc_html__('One comment', 'smartpage'),
            '%'.esc_html__('comments', 'smartpage') 
        ),
        ];
        $data[] = $temp;
    }

    wp_reset_postdata();
}

if(empty($data)) { return;
}

require locate_template('templates/recent-posts.view.php', false, false);
?>
