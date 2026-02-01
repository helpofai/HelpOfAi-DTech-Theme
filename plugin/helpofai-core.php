<?php
/**
 * Plugin Name: HelpOfAi Core
 * Plugin URI: https://helpofai.com
 * Description: Modular core functionality for the HelpOfAi theme.
 * Version: 1.1.0
 * Author: rajib Adhikary
 * Author URI: https://rajibadhikary.com
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define Plugin Constants
define( 'HELPOFAI_CORE_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Load Widget Classes
 */
require_once HELPOFAI_CORE_DIR . 'includes/widgets/class-widget-breaking-news.php';
require_once HELPOFAI_CORE_DIR . 'includes/widgets/class-widget-recent-posts.php';
require_once HELPOFAI_CORE_DIR . 'includes/widgets/class-widget-categories.php';

/**
 * Register All Widgets
 */
function helpofai_register_all_widgets() {
	register_widget( 'HelpOfAi_Breaking_News_Widget' );
	register_widget( 'HelpOfAi_Recent_Posts_Thumbnails_Widget' );
    register_widget( 'HelpOfAi_Categories_Icons_Widget' );
}
add_action( 'widgets_init', 'helpofai_register_all_widgets' );

/**
 * Enqueue Core Plugin Assets
 */
function helpofai_core_assets() {
    // Logic for plugin-specific CSS/JS if needed
}
add_action( 'wp_enqueue_scripts', 'helpofai_core_assets' );
