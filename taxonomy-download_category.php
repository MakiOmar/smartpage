<?php get_header();?>
  <div class="anony-grid">
  	<div class="anony-grid-col anony-grid-row">
        <div class="anony-grid-col-sm-9-5 anony-grid-col">
        <?php
			$this_term = get_term(get_queried_object()->term_id,'download_category');
			$terms = get_terms(array('taxonomy'=>'download_category','hide_empty' => false, 'parent'=>$this_term->term_id,'order'=> 'ASC','depth'=> '1'));
		if(!empty($terms)){	?>
			<div class="anony-container">
			<h3 class="anony-cat-section-title"><?php echo '--- '.ucfirst($this_term->name).' / '.__('sub categories',TEXTDOM).' ---'?></h3>
				<div id="anony-ca-container" class="anony-ca-container">
					<div class="anony-ca-wrapper">
						<?php foreach ($terms as $term) {?>
						<div class="anony-ca-item anony-ca-item-<?php echo $term->term_id ?> anony-grid-col-md-4 anony-grid-col-av-6">
							<div class="anony-ca-item-main">
								<div class="anony-ca-icon"><i class="fa fa-folder-open fa-4x"></i></div>
								<h3 class="anony-ca-item-title"><?php echo $term->name ;?></h3>
								<?php if(!empty($term->description)){?>
								<h4>
									<span class="anony-ca-quote"><?php if(!is_rtl()){ echo '&ldquo;';}else{echo '&rdquo;';}?></span>
									<span><?php echo wp_trim_words( $term->description, 10);?></span>
								</h4>
								<?php }?>
									<a href="<?php echo get_term_link($term->term_id);?>" class="anony-cat-more"><?php esc_html_e('Enter',TEXTDOM)?></a>
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
				<h3 class="anony-cat-section-title"><?php echo '--- '.ucfirst($this_term->name).' / '.__('Category posts',TEXTDOM).' ---'?></h3>
				<div id = "download">
				<?php while ($query->have_posts() ) { $query->the_post();
					get_template_part('templates/download') ;
				}?>
       		</div>
       		<?php  }?>
        </div>
       <?php get_sidebar();?>
	</div>
  </div>
 <?php get_footer();?>