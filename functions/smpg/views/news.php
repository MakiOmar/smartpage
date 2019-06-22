<?php
class Views__News extends Smpg__Generate_Posts_View{
	
	public $IfNot = '';
	
	public $child;
	
	public function __construct($parent){
		parent::__construct($parent->args, $parent->postsTemplate, $parent->resetLoop);
		
		$this->child = $parent;
	}
	
	public function render(){?>
		<div id="didyouknow" class="group">

			<p id="dun-title"><?php esc_html_e('Simple Info',TEXTDOM);?></p>

			<?php echo get_search_form(false);?>

		</div>
		
		<div id="dun-text">
			<div id="dun_text_wrapper"<?php echo (is_rtl() ? ' class="is-rtl"' : '') ;?>>
			
				<?php 
				 while($this->child->post->have_posts()){
			
					$this->child->post->the_post();

					$tnlID = get_the_ID();?>

					<p id="dun-text-<?php echo $tnlID?>" class="dun_text"><?php echo strip_tags(get_the_content($tnlID))?></p>

				<?php } ?>
				
			</div>
		</div>
		
	<?php }
	
	public function IfNot(){
		$this->IfNot = '<div id="didyouknow" class="group search-only">';

		$this->IfNot .= get_search_form(false);

		$this->IfNot .= '</div>';
		
		return $this->IfNot;
	}
}
?>