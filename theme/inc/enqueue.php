<?php
/**
 * Enqueue scripts and styles.
 *
 * @package HelpOfAi
 */

function helpofai_scripts() {
	wp_enqueue_style( 'helpofai-style', get_stylesheet_uri(), array(), '1.0.0' );
    wp_enqueue_style( 'helpofai-header-css', get_template_directory_uri() . '/assets/css/header.css', array(), '1.0.0' );
    wp_enqueue_style( 'helpofai-sidebar-css', get_template_directory_uri() . '/assets/css/sidebar.css', array(), '1.0.0' );
    wp_enqueue_style( 'helpofai-search-css', get_template_directory_uri() . '/assets/css/components/search.css', array(), '1.0.0' );
    wp_enqueue_style( 'helpofai-footer-css', get_template_directory_uri() . '/assets/css/components/footer.css', array(), '1.0.0' );
	wp_enqueue_style( 'helpofai-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap', array(), null );
    
    // Home Page CSS
    if ( is_front_page() || is_home() ) {
        wp_enqueue_style( 'helpofai-home-css', get_template_directory_uri() . '/assets/css/pages/home-page.css', array(), '1.0.0' );
        wp_enqueue_style( 'helpofai-home-cats-css', get_template_directory_uri() . '/assets/css/pages/home-categories.css', array(), '1.0.0' );
    }

    // Single Post CSS
    if ( is_single() || is_page() ) {
        wp_enqueue_style( 'helpofai-single-css', get_template_directory_uri() . '/assets/css/pages/single.css', array(), '1.0.0' );
        wp_enqueue_style( 'helpofai-comments-css', get_template_directory_uri() . '/assets/css/comments.css', array(), '1.0.0' );
        wp_enqueue_style( 'helpofai-related-css', get_template_directory_uri() . '/assets/css/related-posts.css', array(), '1.0.0' );
    }

    // Archive CSS (Used for categories and main Blog page)
    if ( is_archive() || is_home() ) {
        wp_enqueue_style( 'helpofai-archive-css', get_template_directory_uri() . '/assets/css/pages/archive.css', array(), '1.0.0' );
    }
    
    // Global Swarm Background
    if ( get_option( 'helpofai_global_swarm_bg', 0 ) ) {
        wp_enqueue_script( 'helpofai-swarm-engine', get_template_directory_uri() . '/assets/js/swarm-engine.js', array(), '1.0.0', true );
    }
    
    wp_enqueue_script( 'helpofai-theme-js', get_template_directory_uri() . '/assets/js/theme.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'helpofai_scripts' );
