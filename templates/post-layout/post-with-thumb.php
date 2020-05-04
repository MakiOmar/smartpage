<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div class="anony-post-image-wrapper">
	<div class="anony-toggle-excerpt" rel-id="anony-text-<?= $id ?>"><i class="fa fa-arrow-up"></i></div>
	
	<div class="anony-text" id="anony-text-<?= $id ?>">
		<h3 class="anony-thumb-post-title" id="anony-text-<?= $id ?>-title">
			<a href="<?= $permalink ?>"><?= $title ?></a>
		</h3>
		<p class="anony-hidden-paragraph"><?= $excerpt ?></p>
	</div>
	
	<div class="anony-post_meta anony-inside-thumb">
	  <div class="date">
		<i class="fa fa-calendar meta-text"></i>
		<span class="meta-text"><?= $date ?></span>
		</div>
		<div class="anony-comments">
			<i class="fa fa-comments-o meta-text"></i> <?= $comments_number ?>
		</div>
	</div>
	  
	<?php if($has_category) :?>

		<h4>
			<a href="<?= $_1st_category_url ?>"><?= $_1st_category_name?></a>
		</h4>
		
	<?php endif ?>

	<div class="anony-shares-count">
		<i class="fa fa-share-alt"></i>
		<span>1000 <?php esc_html_e('Shares',ANONY_TEXTDOM) ?></span>
	</div>
	  
	<div class="anony-post-title-cover">
		<a href="<?= $permalink ?>" title="<?= $title_attr ?>">.</a>	
   	</div>
   	
   	<div class="anony-thumb">
   		<?= $thumb_img ?>
   	</div>
	
</div>