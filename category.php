<?php get_header();?>
  <div class="anony-grid">
  	<div class="anony-grid-col anony-grid-row">
        <div class="anony-grid-col-sm-9-5 anony-grid-col">
        <?php
			$this_category = get_category($cat);
			$cats=get_categories(array('hide_empty' => '0', 'parent'=>$this_category ->cat_ID,'order'=> 'ASC','depth'=> '1'));
		if(!empty($cats)){	?>
			<div class="anony-container">
			<h3 class="anony-cat-section-title"><?php echo '--- '.ucfirst($this_category->cat_name).' / '.__('sub categories',ANONY_TEXTDOM).' ---'?></h3>
				<div id="anony-ca-container" class="anony-ca-container">
					<div class="anony-ca-wrapper">
						<?php foreach ($cats as $cat) {?>
						<div class="anony-ca-item anony-ca-item-<?php echo $cat->cat_ID ?> anony-grid-col-md-4 anony-grid-col-av-6">
							<div class="anony-ca-item-main">
								<div class="anony-ca-icon"><i class="fa fa-folder-open fa-4x"></i></div>
								<h3 class="anony-ca-item-title"><?php echo $cat->cat_name ;?></h3>
								<?php if(!empty($cat->category_description)){?>
								<h4>
									<span class="anony-ca-quote"><?php if(!is_rtl()){ echo '&ldquo;';}else{echo '&rdquo;';}?></span>
									<span><?php echo wp_trim_words( $cat->category_description, 10);?></span>
								</h4>
								<?php }?>
									<a href="<?php echo get_category_link($cat->term_id);?>" class="anony-cat-more"><?php esc_html_e('Enter',ANONY_TEXTDOM)?></a>
							</div>
						</div>
						<?php }?>
       				</div>
				</div>
			</div>
        <?php }
			$args = array(
				'category__in' => array($this_category ->cat_ID),
				'tax_query' => array(
									array(
										'include_children ' => false,
									),
								),
			);
			$query = new WP_Query( $args );
			if ( have_posts() ) {?>
				<h3 class="anony-cat-section-title"><?php echo '--- '.ucfirst($this_category->cat_name).' / '.__('Category posts',ANONY_TEXTDOM).' ---'?></h3>
			<?php while (have_posts() ) { the_post();
					get_template_part('templates/blog-post') ;
			} }?>
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>