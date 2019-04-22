<?php get_header();?>
  <div class="grid">
  	<div class="grid-col grid-row">
        <div class="grid-col-sm-9-5 grid-col">
        <?php
			$this_term = get_term(get_queried_object()->term_id,'download_category');
			$terms = get_terms(array('taxonomy'=>'download_category','hide_empty' => false, 'parent'=>$this_term->term_id,'order'=> 'ASC','depth'=> '1'));
		if(!empty($terms)){	?>
			<div class="container">
			<h3 class="cat-section-title"><?php echo '--- '.ucfirst($this_term->name).' / '.__('sub categories',TEXTDOM).' ---'?></h3>
				<div id="ca-container" class="ca-container">
					<div class="ca-wrapper">
						<?php foreach ($terms as $term) {?>
						<div class="ca-item ca-item-<?php echo $term->term_id ?> grid-col-md-4 grid-col-av-6">
							<div class="ca-item-main">
								<div class="ca-icon"><i class="fa fa-folder-open fa-4x"></i></div>
								<h3 class="ca-item-title"><?php echo $term->name ;?></h3>
								<?php if(!empty($term->description)){?>
								<h4>
									<span class="ca-quote"><?php if(!is_rtl()){ echo '&ldquo;';}else{echo '&rdquo;';}?></span>
									<span><?php echo wp_trim_words( $term->description, 10);?></span>
								</h4>
								<?php }?>
									<a href="<?php echo get_term_link($term->term_id);?>" class="cat-more"><?php esc_html_e('Enter',TEXTDOM)?></a>
							</div>
						</div>
						<?php }?>
       				</div>
				</div>
			</div>
        <?php }
			$args = array(
				'tax_query' => array(
									array(
									'include_children ' => false,
									'taxonomy'          => 'download_category',
									'field'             => 'slug',
									'terms'             => $this_term->slug,
									),
								),
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {?>
				<h3 class="cat-section-title"><?php echo '--- '.ucfirst($this_term->name).' / '.__('Category posts',TEXTDOM).' ---'?></h3>
				<div id = "download">
				<?php while ($query->have_posts() ) { $query->the_post();
					get_template_part('templates/temp','download') ;
				}?>
       		</div>
       		<?php  }?>
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>