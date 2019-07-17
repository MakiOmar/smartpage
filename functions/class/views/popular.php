<?php
class Views__Popular extends Class__Generate_Posts_View{
	
	public $IfNot = '';
	
	public $child;
	
	public function __construct($parent){
		parent::__construct($parent->args, $parent->postsTemplate, $parent->resetLoop);
		
		$this->child = $parent;
		
		$this->IfNot();
	}
	
	public function render(){?>
		
		<div id="popular" class ="tab_content">
			
				<?php 
				 while($this->child->post->have_posts()){
			
					$this->child->post->the_post();

					$tplID = get_the_ID();?>
					
					<div id="popular-<?php echo $tplID ?>" class="posts-list-wrapper">
					
						<?php if(has_post_thumbnail()){?>
						
							<div class="posts-list-thumb">
								<?php  the_post_thumbnail(array('150','150'),array( 'class' => 'post-thumb'))?>	
							</div>
							
						<?php } ?>
						
							<div class="posts-list">
							
								<div>
									  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
								</div>
								
								<div class="metadata"><i class="fa fa-calendar"></i>&nbsp;<?php echo get_the_date('Y-m-d'); ?></div>
								<div class="metadata"><i class="fa fa-eye"></i>&nbsp;<?php echo getPostViews($tplID)?></div>
								
								<?php get_template_part('templates/rate') ?>
								
							</div>
							
					</div>	

				<?php } ?>
				
		</div>
		
	<?php }
	
	public function IfNot(){
		return $this->IfNot;
	}
}
?>