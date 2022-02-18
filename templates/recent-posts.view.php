<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed direct.ly
}?>

<div id="recent" class ="anony-tab_content">
	<?php
	if ( ! empty( $data ) ) :

		foreach ( $data as $p ) :
			extract( $p )
			?>

			<div id="recent-<?php echo $id; ?>">

				<h3><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h3> 

			<?php foreach ( $meta as $icon => $value ) : ?>

					<div class="anony-metadata">
						<i class="fa fa-<?php echo $icon; ?>"></i>&nbsp;<?php echo $value; ?>
					</div>
					 
			<?php endforeach ?>

			</div>    
			 
			<?php
		endforeach;

	else :
		?>

		<p><?php echo $no_posts; ?></p>

	<?php endif ?>

</div>
