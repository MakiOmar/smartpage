<?php
/**
 * Post view generator
 *
 * PHP version 7.3 Or Later
 *
 * @category WordPress
 * @package  SmartPage
 * @author   Makiomar <info@makior.com>
 * @license  https://makiomar.com SmartPage Licence
 * @link     https://makiomar.com
 */
defined( 'ABSPATH' ) or die(); // Exit if accessed direct

! class_exists( 'ANONY_Generate_Posts_View' )) or return;

/**
 * Post view generator class
 *
 * @category   Posts
 * @package    Posts
 * @subpackage Menu
 * @author     Makiomar <info@makior.com>
 * @license    https://makiomar.com SmartPage Licence
 * @link       https://makiomar.com
 */
class ANONY_Generate_Posts_View {


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
	* @var integer $excerptLength  Stores excerpt length
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

	/**
	 * Class constructor
	 *
	 * @param array  $args     array to create post object
	 * @param string $template the name of posts template
	 * @param bool   $reset    if the loop need to be reset
	 */
	public function __construct( $args, $template = 'blog-post.view', $reset = false ) {
		$this->resetLoop = $reset;

		$this->postsTemplate = $template;

		$this->args = $args;

		$this->resetLoop = $reset;

		$this->post = new WP_Query( $args );

	}

	/**
	 * Display posts list view
	 *
	 * @return void
	 */
	public function postsView() {
		$className = 'ANONY_views__' . ucfirst( $this->postsTemplate );

		if ( class_exists( $className ) ) {

			$view = new $className( $this );

			if ( method_exists( $view, 'IfNot' ) ) {
				$this->IfNot = $view->IfNot();
			}
		}

		if ( $this->post->have_posts() ) {
			if ( isset( $view ) ) {
				if ( ! is_null( $this->msg ) && ! empty( $this->msg ) ) {
					$view->msg = $this->msg;
				}
				$view->render();
			}

			if ( $this->resetLoop === true ) {

				wp_reset_postdata();

			}
		} else {
			echo $this->IfNot;
		}
	}

}
