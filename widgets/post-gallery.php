<?php
namespace Elements\widgets;

class Elementor_Post_Gallery extends \Elementor\Widget_Base {
	public function get_name() {
		return 'post_filter';
	}

	public function get_title() {
		return __( 'Post Filter', 'elementor-pro-add-ons' );
	}

	public function get_icon() {
		return 'eicon-inner-section';
	}

	public function get_categories() {
		return [ 'elementor-pro-add-ons' ];
	}
    

}