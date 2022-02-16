<?php
if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}
?>
<div class="anony-nothumb-post">

    <h3 class="anony-thumb-post-title">
        <a href="<?php echo $permalink ?>"><?php echo $title ?></a>
    </h3>

    <div class="anony-post_meta">
        
        <div class="date">
            <i class="fa fa-calendar meta-text"></i>
            <span class="meta-text"><?php echo $date ?></span>
        </div>
        
        <div class="anony-comments">
            <i class="fa fa-comments-o meta-text"></i>
            <?php echo $comments_number ?>
        </div>

        <?php if($has_category) {?>
        
            <div class="category">
            
                <i class="fa fa-folder-open meta-text"></i>
                
                <a class="meta-text" href="<?php echo $_1st_category_url ?>"><?php echo $_1st_category_name ?></a>
            
            </div>
        
        <?php }?>

        
    </div>

    <p><?php echo $excerpt ?></p>

</div>
