<?php
/**
 * Search form template
 *
 * PHP version 7.3 Or Later
 * 
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined('ABSPATH') or die(); // Exit if accessed direct

$search_query = get_search_query();
$search_text  = esc_attr__('Search', ANONY_TEXTDOM);
?>

<form 
id="anony-searchform" 
class="anony-search-form anony-search" 
action="<?php echo ANONY_BLOG_URL ?>" 
method="get">

    <input 
    type="search" 
    class="anony-search-input" 
    name="s" 
    id="s" 
    value="<?php echo $search_query ?>" 
    placeholder="<?php echo $search_text ?>" />

    <button 
    type="submit" 
    class="anony-form_submit" 
    name="submit" 
    form="anony-searchform" 
    value="<?php echo $search_text ?>">
    <i class="fa fa-search"></i>
    </button>
</form>

