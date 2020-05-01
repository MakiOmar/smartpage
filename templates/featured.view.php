<div id="anony-slider-wrapper">
	<?php if($message !== '') : var_dump($message) ?>
		
		<p><i class="fa fa-frown-o fa-4x"></i></p>
		<p class="anony-warning"><?= $message ?></p>
		
	<?php endif ?>
	
	<?php if($data !== []) : ?>	
		
		<div id="anony-featured">
		
			<div id="anony-active-slide">
				<?php foreach($data as $p) : extract($p) ?>

						<div class="anony-view">

							  <?= $thumb_img?>

							  <div class="anony-title-readmore">

								  <h2 class="anony-slide-title">
								  	<a href="<?= $permalink ?>"><?= $title ?></a>
								  </h2>

								  <a class="anony-featured-button" href="<?= $permalink ?>"><?= $read_more ?></a>

							  </div>
							</div>
					<?php  endforeach ?>
				</div>

			<h3 class="anony-featured-posts-title">
	
				<a href="<?= $title_link ?>"><?= $title_text ?></a>

			</h3>

			<div id="anony-slides-list" class="">
				
				<?php foreach($slider_nav as $item) : extract($item) ?>
					
					<a href="<?= $permalink ?>" class="<?= $class ?>anony-slide-item anony-grid-col-<?= $count ?>">

						<img src="<?= $thumbnail_img ?>" alt="<?= $title_attr ?>"/>

					</a>
					
				<?php endforeach ?>
				
			</div>

		</div>
	
	<?php endif ?>
</div>