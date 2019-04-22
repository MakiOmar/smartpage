<?php 

class Smpg__Cf__Textarea extends Smpg__Custom_Field{
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
			
			$value = get_post_meta( $this->post->ID, $this->id, true );
			
		}else{
			
			$value = '';
			
		}
		
		echo '<textarea rows="4" cols="20" id="'.$this->idAttr.'" name="'.$this->id.'">'.esc_textarea($value).'</textarea> ';
	}
} 

