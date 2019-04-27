<?php
class Smpg__Views__Featured extends Smpg__Generate_Posts_View{
	
	public $IfNot = '';
	
	public $child;
	
	public $featuredIDs = array();
	
	public function __construct($parent){
		parent::__construct($parent->args, $parent->postsTemplate, $parent->resetLoop);
		
		$this->child = $parent;
		
		$this->IfNot();
	}
	
	public function render(){?>
		
		<div id="slider-wrapper">
	
		<div id="featured">
			<div id="active-slide">
				<?php 
					 while($this->child->post->have_posts()){

						$this->child->post->the_post();
						if (has_post_thumbnail()){

						$this->featuredIDs[]= get_the_ID();

						$link = get_the_permalink();?>

						<div class="view">

						  <?php the_post_thumbnail('full');?>

						  <div class="title-readmore">

							  <h2 class="slide-title"><a href="<?php echo $link ?>"><?php the_title() ;?></a></h2>

							  <a class="featured-button" href="<?php echo $link?>"><?php esc_html_e('Read more', TEXTDOM)?></a>

						  </div>
						</div>
					<?php }
				} ?>
			</div>

			<?php if(count($this->featuredIDs) > 0){ ?>
			
			<h3 class="featured-posts-title">
			
				<a href="<?php echo get_category_link($this->child->args['cat']) ?>">
				
					<?php echo get_cat_name( $this->child->args['cat'] ) ?>
					
				</a>
				
			</h3>
				
		
			<div id="slides-list" class="">

			<?php foreach($this->featuredIDs as $pID) {?>

				<a href="<?php echo get_the_permalink($pID) ?>" class="<?php if(array_search($pID,$this->featuredIDs) == 0) echo 'active-slide'?> slide-item grid-col-<?php echo count($this->featuredIDs)?>">
				
					<img src="<?php echo get_the_post_thumbnail_url($pID,'thumbnail') ?>" alt="<?php echo get_the_title($pID) ?>"/>
					
				</a>

				<?php }?>

			</div>
		
		<?php }?>

			</div>
		</div>
		
	<?php }
	
	public function IfNot(){
		return $this->IfNot;
	}
}
?>