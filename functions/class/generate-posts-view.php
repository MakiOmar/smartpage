<?php
class Class__Generate_Posts_View{

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
	*@var  array  $args  arge of WP_Query
	*/

	public $args = array();
	
	/*
	*@var  string $IfNot  stores the else part
	*/
	public $IfNot = '';
	
	/*
	*@var  integer $IfNot  stores the else part
	*/
	public $excerptLength = 15;
	
	
	/*
	*@var array  $PostsIds post ids inside the loop for further use
	*/
	public $PostsIds = array();
	
	/*
	*@var string message to show 
	*/
	public $msg = null;
	
	/*
	*generatePostView constructor
	*@param  array   $args      array to create post object
	*@param  string  $template  the name of posts template
	*@param  bool    $reset     if the loop need to be reset
	*/

	public function __construct($args, $template = 'blog-post', $reset = false){

		$this->resetLoop = $reset;

		$this->postsTemplate = $template;
		
		$this->args = $args;
		
		$this->resetLoop = $reset;

		$this->post = new WP_Query($args);

	}
	
	/*
	*Display posts list view
	*/
	public function postsView(){
		$className= 'Views__'.ucfirst($this->postsTemplate);
		
		if(class_exists($className)){
				
			$view = new $className($this);

			if(method_exists($view, 'IfNot')){
				$this->IfNot = $view->IfNot();
			}
				
		}
		
		if($this->post->have_posts()){
			if(isset($view)){
				if(!is_null($this->msg) && !empty($this->msg)){
					echo $this->msg;
				}
				$view->render();
			}
				
			if($this->resetLoop === true){

				wp_reset_postdata();

			}
			
		}else{
			echo $this->IfNot;
		}
	}

}