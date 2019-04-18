<?php 

class Smpg__Cf__Text extends Smpg__Custom_Field{
	public $post, $metaBox, $id;
	public function __construct($post, $metaBox){
		parent::__construct();
		$this->post = $post;
		$this->metaBox= $metaBox;
		$this->id= $this->metaBox['id'];
		$this->idAttr= str_replace('_', '-', $this->id);
	}
	
	public function render(){
		
		wp_nonce_field( $this->id.'_action', $this->id.'_nonce' );
		
		if(get_post_meta( $this->post->ID, $this->id, true )){
			
			$value = checked(get_post_meta( $this->post->ID, $this->id, true ), 'on', false);
			
		}else{
			
			$value = '';
			
		}

		echo '<input class="widefat" type="text" id="'.$this->idAttr.'" name="'.$this->id.'" value="'.$value.'"/>';
	}
} 