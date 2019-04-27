<?php
class Smpg__Views__Downloads extends Smpg__Generate_Posts_View{
	
	public $IfNot = '';
	
	public $child;
	
	public function __construct($parent){
		parent::__construct($parent->args, $parent->postsTemplate, $parent->resetLoop);
		
		$this->child = $parent;
		
		$this->IfNot();
	}
	
	public function render(){?>
		
		<div class="section">
			<div><h4 class="section_title clearfix"><?php esc_html_e('Suggested downloads',TEXTDOM);?></h4></div>
				<div class="posts-wrapper">
					<div id="download">

						<?php 
						 while($this->child->post->have_posts()){

							$this->child->post->the_post();

							$tdPostId = get_the_ID();

							$curr_download_meta = get_post_meta( $tdPostId, 'smpg_download_attachment', true );

							$download_times = get_post_meta($tdPostId,'download_times',true);

							if(empty($download_times)){

								$download_times = 0;

							}?>

							<div id="download-<?php echo $tdPostId ?>" class="grid-col-max-480-6 grid-col-av-4 grid-10-col-md-2">

								<div class="grid-col post-contents">

								  <div class="download-meta">

									<div class="hover-toggle post-image-wrapper" style="background-color: transparent">

									<span id="download-<?php echo $tdPostId?>-count" class="download-counter"><?php echo $download_times.'<br>'.esc_html__('Downloads',TEXTDOM) ?></span>


									  <?php if( has_post_thumbnail() ){

												the_post_thumbnail(array('160','180'));

											}else{?>

												<img src="<?php echo get_theme_file_uri();?>/images/temporary-book-bg.png" alt="<?php the_title() ?>"/>

												<?php }?>

									  </div>

									</div>

									<h4 class="download-title"><?php the_title() ?></h4>

									<div class="download">

										<a title="download-<?php echo $tdPostId?>" target="_blank" class="smpg-download" href="<?php echo $curr_download_meta ?>"><i class="fa fa-download"></a></i>

									</div>

								</div>

							</div>

						<?php }

						if($this->child->resetLoop === true){
							wp_reset_postdata();
						};?>

				</div>
			</div>
		</div>
		
	<?php }
	
	public function IfNot(){
		echo $this->IfNot;
	}
}
?>