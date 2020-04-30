<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}?>

<div id="recent" class ="anony-tab_content">
    <?php if ( !empty($data) ) :

		foreach($data as $p ) :  extract($p) ?>

			<div id="recent-<?= $id ?>">

				<h3><a href="<?= $permalink ?>"><?= $title?></a></h3> 

				<?php  foreach ($meta as $icon => $value) : ?>

					<div class="anony-metadata">
						<i class="fa fa-<?= $icon?>"></i>&nbsp;<?= $value ?>
					</div>
					
				<?php endforeach ?>

		    </div>	
		    
	 	<?php endforeach;
				
	else: ?>

		<p><?= $no_posts ?></p>

	<?php endif ?>

</div>