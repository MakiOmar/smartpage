<?php get_header();?>
  <div class="grid">
  	<div class="grid-col grid-row">
        <div class="grid-col-sm-9-5 grid-col">
        <?php
			$this_category = get_category($cat);
			$cats=get_categories(array('hide_empty' => '0', 'parent'=>$this_category ->cat_ID,'order'=> 'ASC','depth'=> '1'));
		if(!empty($cats)){	?>
			<div class="container">
			<h3 class="cat-section-title"><?php echo '--- '.ucfirst($this_category->cat_name).' / '.__('sub categories',TEXTDOM).' ---'?></h3>
				<div id="ca-container" class="ca-container">
					<div class="ca-wrapper">
						<?php foreach ($cats as $cat) {?>
						<div class="ca-item ca-item-<?php echo $cat->cat_ID ?> grid-col-md-4 grid-col-av-6">
							<div class="ca-item-main">
								<div class="ca-icon"><i class="fa fa-folder-open fa-4x"></i></div>
								<h3 class="ca-item-title"><?php echo $cat->cat_name ;?></h3>
								<?php if(!empty($cat->category_description)){?>
								<h4>
									<span class="ca-quote"><?php if(!is_rtl()){ echo '&ldquo;';}else{echo '&rdquo;';}?></span>
									<span><?php echo wp_trim_words( $cat->category_description, 10);?></span>
								</h4>
								<?php }?>
									<a href="<?php echo get_category_link($cat->term_id);?>" class="cat-more"><?php esc_html_e('Enter',TEXTDOM)?></a>
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
				<h3 class="cat-section-title"><?php echo '--- '.ucfirst($this_category->cat_name).' / '.__('Category posts',TEXTDOM).' ---'?></h3>
			<?php while (have_posts() ) { the_post();
					get_template_part('templates/blog-post') ;
			} }?>
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>