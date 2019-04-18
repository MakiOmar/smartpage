<?php
	
if( ! class_exists( 'Smpg__Custom_Field' )){
	class Smpg__Custom_Field{
		public $postType = 'post';
		public $metaBoxes;
		
		public function __construct($meta_boxes = array()){
			$this->metaBoxes = $meta_boxes;
			
			add_action( 'add_meta_boxes_'.$this->postType, array(&$this, 'add_meta_boxes') );
		}
		
		public function add_meta_boxes(){
			foreach($this->metaBoxes as $id => $metaBox){
				if(isset($metaBox['post_type'])){
					$this->postType = $metaBox['post_type'];
				}
				add_meta_box( $id, $metaBox['title'], array($this, 'smpg_metabox_cb'), $this->postType, $metaBox['context'],'core', array($metaBox));
			}
		}
		
		public function smpg_metabox_cb($post, $metaBox){
			$class_name = 'Smpg__Cf__'.ucfirst($metaBox['args'][0]['type']);
			
			if(class_exists($class_name)){
				
				$input = new $class_name($post, $metaBox);
				
				$input->render();
				
			}			
			
		}
		
		
	}
}
