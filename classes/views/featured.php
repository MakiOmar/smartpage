<?php
class ANONY_views__Featured extends ANONY_Generate_Posts_View{
	
	public $IfNot = '';
	
	public $child;
	
	/*
	*@var string message to show 
	*/
	public $msg;
	
	public $featuredIDs = array();
	
	public function __construct($parent){
		parent::__construct($parent->args, $parent->postsTemplate, $parent->resetLoop);
		
		$this->child = $parent;
		
		$this->IfNot();
	}
	
	public function render(){?>
		<?php
		
		$slider_nav = '';
		
		 while($this->child->post->have_posts()){

			$this->child->post->the_post();

			if (has_post_thumbnail() && get_the_post_thumbnail_url()){

				$this->featuredIDs[]= get_the_ID();

			} 
		} 
		
		if(count($this->featuredIDs) > 0){ ?>
		<div id="anony-slider-wrapper">
			<?php
				if($this->msg){
					echo '<p class="anony-warning">'.$this->msg.'</p>';
				}
			?>
			<div id="anony-featured">
			
				<div id="anony-active-slide">
					<?php foreach($this->featuredIDs as $pID) {
							$link = get_the_permalink($pID);?>

							<div class="anony-view">

								  <?php echo get_the_post_thumbnail($pID, 'full');?>

								  <div class="anony-title-readmore">

									  <h2 class="anony-slide-title"><a href="<?php echo $link ?>"><?php echo get_the_title($pID) ;?></a></h2>

									  <a class="anony-featured-button" href="<?php echo $link?>"><?php esc_html_e('Read more', ANONY_TEXTDOM)?></a>

								  </div>
								</div>
						<?php 

						$slider_nav .= '<a href="'.get_the_permalink($pID).'" class="'. (array_search($pID,$this->featuredIDs) == 0 ?  'anony-active-slide ': '').'anony-slide-item anony-grid-col-'.count($this->featuredIDs).'">

							<img src="'.get_the_post_thumbnail_url($pID,'thumbnail').'" alt="'.get_the_title($pID).'"/>

						</a>';} ?>
					</div>

				<h3 class="anony-featured-posts-title">
					<?php
						if(isset($this->child->args['cat'])){?>

							<a href="<?php echo get_category_link($this->child->args['cat']) ?>"><?php echo get_cat_name( $this->child->args['cat'] ) ?></a>

						<?php }else{?>

							<a href="#"><?php esc_html_e('Featured Posts', ANONY_TEXTDOM); ?></a>

						<?php } ?>

				</h3>

				<div id="anony-slides-list" class="">
					<?php echo $slider_nav; ?>
				</div>

			</div>
		</div>
		<?php }else{?>
						 
			<p><i class="fa fa-frown-o fa-4x"></i></p>
			
			<?php wp_kses(_e('<p>Sorry! but we can\'t find any post with available thumbnail to show in slider</p>', ANONY_TEXTDOM), array('p'=>array())) ?>
						 
		 <?php }?>
		
	<?php }
	
	public function IfNot(){
		return $this->IfNot;
	}
}
?>