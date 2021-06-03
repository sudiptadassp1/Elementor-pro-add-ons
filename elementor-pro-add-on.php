<?php
/**
 * Plugin Name: Elementor Pro Add-ons
 * Description: Additional custom widgets for elementor
 * Plugin URI:  #
 * Version:     1.0.0
 * Author:      Sudipta Das
 * Author URI:  dassuva02@gmail.com
 * Text Domain: elementor-pro-add-ons
 */
namespace Elements;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elements\widgets\Elementor_Post_Gallery;
// use Elements\Traits\Elements_Category;

final class Elementor_Pro_Add_ons {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.0';
	private static $_instance = null;
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
	}

	public function i18n() {
		load_plugin_textdomain( 'elementor-pro-add-ons' );
	}

	public function on_plugins_loaded() {
		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}
	}

	public function is_compatible() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}

		return true;

	}

	public function register_custom_widget_categories()
    {
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'elementor-pro-add-ons',
            [
                'title' => __('Elementor Pro Add-ons', 'elementor-pro-add-ons'),
                'icon' => 'fa fa-plug',
            ]
        );
    }

	public function init() {
	
		$this->i18n();
		add_action('elementor/init', [$this, 'register_custom_widget_categories']);
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		// add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

	}

	public function init_widgets() {

		// Include Widget files
		require_once( __DIR__ . '/widgets/post-gallery.php' );

		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Elementor_Post_Gallery() );

	}

	public function init_controls() {

		// Include Control files
		require_once( __DIR__ . '/controls/test-control.php' );

		// Register control
		\Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );

	}
	
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-pro-add-ons' ),
			'<strong>' . esc_html__( 'Elementor Pro Add-ons', 'elementor-pro-add-ons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-pro-add-ons' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-pro-add-ons' ),
			'<strong>' . esc_html__( 'Elementor Pro Add-ons', 'elementor-pro-add-ons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-pro-add-ons' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-pro-add-ons' ),
			'<strong>' . esc_html__( 'Elementor Pro Add-ons', 'elementor-pro-add-ons' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-pro-add-ons' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

}

Elementor_Pro_Add_ons::instance();