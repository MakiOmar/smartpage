<div id="anony-slider-wrapper" class="white-bg">
	<?php if($message !== '') : ?>
		
		<p><i class="fa fa-frown-o fa-4x"></i></p>
		<p class="anony-warning"><?= $message ?></p>
		
	<?php endif ?>
	
	<?php if($data !== []) : ?>	
		
		<div id="anony-featured" data-slider='<?php echo json_encode($slider_data) ?>'>
		
			<div id="anony-active-slide">
				<?php foreach($data as $index => $p) : extract($p);  ?>

						<div id="anony-item-<?= $id ?>" class="anony-view">

							  <?= $thumb_img?>

							  <div class="anony-title-readmore">

								  <h2 class="anony-slide-title">
								  	<a href="<?= $permalink ?>"><?= $title ?></a>
								  </h2>
								  <?php if($show_read_more) : ?>
								  
								  	<a class="anony-featured-button" href="<?= $permalink ?>"><?= $read_more ?></a>
								  
								  <?php endif; ?>
							  </div>
							</div>
					<?php  endforeach ?>
				</div>
			<div class="anony-skew-bg">
			<h3 class="anony-featured-posts-title">
	
				<a href="<?= $title_link ?>"><?= $title_text ?></a>

			</h3>
			</div>
			
			<?php if($show_pagination) : ?>
				<div id="anony-slides-list">

					<?php foreach($slider_nav as $item) : extract($item) ?>
						
						<?php if($pagination_type == 'thumbnails') : ?>

							<a href="<?= $permalink ?>" data-id="anony-item-<?= $id ?>" class="<?= $class ?>anony-slide-item">

								<img src="<?= $thumbnail_img ?>" alt="<?= $title_attr ?>"/>

							</a>
						<?php else : ?>
							<div data-id="anony-item-<?= $id ?>" class="<?= $class ?>anony-slide-item anony-pagination-dot"></div>
						<?php endif ?>
					<?php endforeach ?>

				</div>
			<?php endif ?>
		</div>
	
	<?php endif ?>
</div>