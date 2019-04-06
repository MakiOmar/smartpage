<?php
class Smpg_Generate_Posts_View{

	/*
	*@var  string  $postsTemplate  the posts template 
	*/

	public $postsTemplate;

	/*
	*@var  bool  $resetLoop  a flag to determine if the loop need to be reset 
	*/

	public $resetLoop;

	/*
	*@var  object  $post  the post object 
	*/

	public $post;

	/*
	*@var  bool  $HomeView  Flage to check if post view will be at homepage
	*/

	public $HomeView = false;


	/*
	*@var  string  $sectionWrapperOpen  posts section container opening wrapper
	*/

	public $sectionWrapperOpen = '<div>';


	/*
	*@var  string  $sectionWrapperClose  posts section container closing wrapper
	*/

	public $sectionWrapperClose = '</div>';
	
	/*
	*@var  string  $beforeSection  add any thing before posts wrapper
	*/

	public $beforeSection = '';
	
	/*
	*@var  string  $beforeSection  add any thing before posts wrapper
	*/

	public $afterSection = '';
	
	/*
	*@var  string $IfNot  stores the else part
	*/
	public $IfNot = '';
	
	
	/*
	*@var array  $PostsIds post ids inside the loop for further use
	*/
	public $PostsIds = array();
	
	/*
	*generatePostView constructor
	*@param  array   $args      array to create post object
	*@param  string  $template  the name of posts template
	*@param  bool    $reset     if the loop need to be reset
	*/

	public function __construct($args, $template = 'blog-post', $reset = false){

		$this->resetLoop = $reset;

		$this->postsTemplate = $template;

		$this->post = new WP_Query($args);

	}
	
	/*
	*Display posts list view
	*/
	public function postsView(){

		if($this->post->have_posts()){

			echo $this->beforeSection;
			
			echo $this->sectionWrapperOpen;

				$this->loopPosts();

			echo $this->sectionWrapperClose;
			
			echo $this->afterSection;

		}else{
			echo $this->ifNot();
		}
	}
	
	/*
	*Loops through posts list view
	*/
	public function loopPosts(){
		while ($this->post->have_posts() ) {
			
			$this->post->the_post();

			$this->PostsIds[] = get_the_ID();

			get_template_part('templates/temp', $this->postsTemplate);
				
		}
		
		if($this->resetLoop === true){
			wp_reset_postdata();
		}
	}
	
	/*
	*fired if no posts found
	*/
	public function ifNot(){
		return $this->IfNot;
	}
	

}