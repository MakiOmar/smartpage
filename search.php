<?php 
get_header();
?>
  <div class="anony-grid">
  	<div class="anony-grid-row">
      <div class="anony-grid-col">
        <div class="anony-grid-col-sm-9-5">
        <?php 

			if ( have_posts() ) {
				while (have_posts() ) { the_post();
				get_template_part('templates/blog-post') ;

				} 
			}
			if(is_rtl()){
				$prev_text = '<i class="fa fa-arrow-right"></i>';
				$next_text = '<i class="fa fa-arrow-left"></i>';
			}else{
				$prev_text = '<i class="fa fa-arrow-left"></i>';
				$next_text = '<i class="fa fa-arrow-right"></i>';
			}
        	the_posts_pagination( array(
					'type' => 'list',
					'prev_text' => $prev_text,
					'next_text' => $next_text,
					'screen_reader_text'=>' ',

				) );
		?>	
        </div>
       <?php get_sidebar();?>
	  </div>
	</div>
  </div>
 <?php get_footer();?>