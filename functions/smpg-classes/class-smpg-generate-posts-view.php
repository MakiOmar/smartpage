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

	public $HomeView;


	/*
	*@var  string  $sectionWrapperOpen  posts section container opening wrapper
	*/

	public $sectionWrapperOpen;


	/*
	*@var  string  $sectionWrapperClose  posts section container closing wrapper
	*/

	public $sectionWrapperClose;
	/*
	*generatePostView constructor
	*@param  array   $args      array to create post object
	*@param  string  $template  the name of posts template
	*@param  bool    $reset     if the loop need to be reset
	*/

	public function __construct($args, $template, $reset = false){

		$this->resetLoop = $reset;

		$this->postsTemplate = $template;

		$this->HomeView = false;

		$this->sectionWrapperOpen = '';

		$this->sectionWrapperClose = '';

		$this->post = new WP_Query($args);

	}

	public function postsView(){

		if($this->post->have_posts()){

			echo $this->sectionWrapperOpen;

			$this->loopPosts();

			echo $this->sectionWrapperClose;


		}
	}

	public function loopPosts(){
		while ($this->post->have_posts() ) {
			
			$this->post->the_post();
				
				get_template_part('templates/temp', $this->postsTemplate);
				
		}
		
		if($this->resetLoop === true){
			wp_reset_postdata();
		}
	}

}