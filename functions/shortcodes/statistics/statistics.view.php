<?php
if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly
}
?>
<div id="<?php echo $id ?>" class="anony-counter-wrapper">
    <div class="anony-counter-icon"><i class="fa fa-<?php echo $icon ?> fa-4x"></i></div>
    
    <div class= "anony-counter">
        <div class= "anony-counter-inner counter"><?php echo $count ?></div>
    </div>
    
    <h3 class="anony-counter-title"><?php echo $title ?></h3>
</div>
