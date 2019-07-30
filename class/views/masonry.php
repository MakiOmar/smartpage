<?php
class Views__Masonry extends Class__Generate_Posts_View{
	
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
	
	public function render(){
		
		if(is_front_page() or is_home()){?>
		<div class="anony-section">
			<div>
				<h4 class="anony-section_title clearfix"><?php esc_html_e('Recent Posts',TEXTDOM);?></h4>
			</div>
			<?php
				if($this->msg){
					echo '<p class="anony-warning">'.$this->msg.'</p>';
				}
			?>
			<div id="anony-masonry">
		<?php }else{?>
			<div>
				
		<?php }?>
			<div id="anony-blog-posts">
			<?php
					while($this->child->post->have_posts()){
					 
					$this->child->post->the_post();
					 
					$tbp_post_id = get_the_ID();?>

					<div id="post-<?php echo $tbp_post_id?>" class="anony-post-wrapper anony-grid-col-max-480-12 anony-grid-col-av-12 anony-grid-col-md-6 anony-grid-col">
						<div class="anony-post-contents anony-blog-post anony-grid-col">

						  <div class="anony-post-info">

						   <?php if( has_post_thumbnail() && is_url_exist(get_the_post_thumbnail_url($tbp_post_id))){

								get_template_part('templates/post-layout/post','with-thumb') ;

							}else{

								get_template_part('templates/post-layout/post','without-thumb') ;

							}?>

							<div class="anony-extra-metas">

								<div class="anony-author-avatar">

									<?php echo get_avatar(get_the_author_meta('ID'),32) ?>

								</div>

								<div class="author-name">

									<span>

										<?php echo  esc_html__('By',TEXTDOM).' '.get_the_author(); ?>

									</span>

								</div>

								<div>

									<a class="button anony-button" href="<?php echo esc_url( get_the_permalink() ) ?>"><?php esc_html_e('Read more',TEXTDOM) ?></a>
									
									

								</div>

							</div>

						</div>

					  </div>

					</div>

				<?php } ?>
				</div>
				</div>
			</div>
				
		
		
	<?php }
	
	public function IfNot(){
		return $this->IfNot;
	}
}
?>