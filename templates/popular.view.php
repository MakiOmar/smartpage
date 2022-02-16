<?php
if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}
?>
<div id="anony-popular" class ="anony-tab_content">
            
    <?php foreach ($data as $p) : 
        extract($p); 
        $pID = $id 
        ?>
        
        <div id="anony-popular-<?php echo $id ?>" class="anony-posts-list-wrapper">
        
        <?php if($thumb && $thumb_exists && !$hide_thumb) : ?>
            
                <div class="anony-posts-list-thumb">
            <?php echo $thumb_img  ?>    
                </div>
                
        <?php endif ?>
            
                <div class="anony-posts-list">
                
                    <div>
                          <h3><a href="<?php echo $permalink ?>"><?php echo $title ?></a></h3> 
                    </div>
                    
        <?php if (!$hide_date) : ?>
                        
                        <div class="anony-metadata"><i class="fa fa-calendar"></i>&nbsp;<?php echo $date ?></div>
                        
        <?php endif ?>
                    
        <?php if (!$hide_views) : ?>
                        
                        <div class="anony-metadata"><i class="fa fa-eye"></i>&nbsp;<?php echo $views ?></div>
                    
        <?php endif ?>
                    
                    
        <?php 
        if (!$hide_rating) :
                        
            include locate_template('models/rate.php', false, false); 
                        
        endif;
        ?>
                    
                </div>
                
        </div>    

    <?php endforeach ?>
        
</div>
