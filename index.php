<?php
/**
 * SmartPage Theme index
 * 
 * PHP version 7.3 Or Later
 * 
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined('ABSPATH') or die(); 

$anonyOptions = ANONY_Options_Model::get_instance();

$grid = $anonyOptions->posts_grid;

$data = [];

if (have_posts()) {
    while (have_posts() ) {
        the_post();
        
        $data[] = anony_common_post_data();

    }
    

    $pagination = anony_pagination();
}
if (!empty($data)) {
    include locate_template('templates/index.view.php', false, false);
}


?>