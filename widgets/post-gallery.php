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
		return [ 'basic' ];
	}
    
	protected function _register_controls(){
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Contents', 'elementor-pro-add-ons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'title',
			[
				'label' => __( 'Title:', 'elementor-pro-add-ons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'placeholder' => __( 'Type your title here', 'elementor-pro-add-ons' ),
			]
		);

		$this->add_control(
			'url',
			[
				'label' => __( 'Link:', 'elementor-pro-add-ons' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'url',
				'placeholder' => __( 'https://your-link.com', 'elementor-pro-add-ons' ),
			]
		);

		$this->end_controls_section();

	}

	protected function render(){
		$settings = $this->get_settings_for_display();
		echo "<a href='".$settings['url']."'>".$settings['title']."</a>";
	}

	