<?php $tnlID = get_the_ID();?>

<p id="dun-text-<?php echo $tnlID?>" class="dun_text"><?php echo strip_tags(get_the_content($tnlID))?></p>