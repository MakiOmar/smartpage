<?php
if (! defined('ABSPATH') ) {
    exit; // Exit if accessed direct.ly
}

    
$anony_options = ANONY_Options_Model::get_instance();
    
$args = array('post_type' => 'post', 'posts_per_page' => 4, 'order' => 'DESC');

$sliderOpt   = $anony_options->slider;
$featuredCat = $anony_options->featured_cat;
$featuredTax = $anony_options->featured_tax;

$featured_args = $args;
    
if($sliderOpt != 'rev-slider') {
    
    if($sliderOpt == 'featured-cat' && $featuredCat != '0') {
        
        $cat_ = get_term_by( 
            'id', 
            $featuredCat,
            $featuredTax
        );
        
        if($cat_) {
            $featured_args['category__not_in'] = $cat_->term_id;
        }
        

    }elseif($sliderOpt == 'featured-post') {
        $featured_args['post__not_in'] =  ANONY_Post_Help::queryIdsByMeta('anony__set_as_featured', 'on');

    }
    
}

/*
get_term(58)->name => array_merge(
        $featured_args, 
        [
            'tax_query' => [
                [
                 'taxonomy' => 'category', //the slug of the taxonomy you want to get
                 'terms' => [58]
                ]
            ]
                
        ]
    )
*/
$sections = [
    esc_html__('Recent Posts', 'smartpage') => $featured_args,
    []
    
    
];

foreach($sections as $title => $section_args){
    anony_category_posts_section($section_args, $title);
}




?>                