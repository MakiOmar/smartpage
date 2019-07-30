<?php
class Views__Popular extends ANONY__Generate_Posts_View{
	
	public $IfNot = '';
	
	public $child;
	
	/*
	*@var string message to show 
	*/
	public $msg;
	
	public function __construct($parent){
		parent::__construct($parent->args, $parent->postsTemplate, $parent->resetLoop);
		
		$this->child = $parent;
		
		$this->IfNot();
	}
	
	public function render(){?>
		
		<div id="anony-popular" class ="anony-tab_content">
			
				<?php
				if($this->msg){
					echo '<p class="anony-warning">'.$this->msg.'</p>';
				}
				 while($this->child->post->have_posts()){
			
					$this->child->post->the_post();

					$tplID = get_the_ID();?>
					
					<div id="anony-popular-<?php echo $tplID ?>" class="anony-posts-list-wrapper">
					
						<?php if(has_post_thumbnail()){?>
						
							<div class="anony-posts-list-thumb">
								<?php  the_post_thumbnail(array('150','150'),array( 'class' => 'post-thumb'))?>	
							</div>
							
						<?php } ?>
						
							<div class="anony-posts-list">
							
								<div>
									  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
								</div>
								
								<div class="anony-metadata"><i class="fa fa-calendar"></i>&nbsp;<?php echo get_the_date('Y-m-d'); ?></div>
								<div class="anony-metadata"><i class="fa fa-eye"></i>&nbsp;<?php echo anony_get_post_views($tplID)?></div>
								
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