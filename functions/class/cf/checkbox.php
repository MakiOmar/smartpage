<?php 

class Cf__Checkbox extends Class__Custom_Field{
	public $post, $metaBox, $id, $idAttr;
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
			
			$checked = checked(get_post_meta( $this->post->ID, $this->id, true ), 'on', false);
			
		}else{
			
			$checked = '';
			
		}

		echo '<input class="widefat" type="checkbox" id="'.$this->idAttr.'" name="'.$this->id.'"'.$checked.'/>';
	}
} 