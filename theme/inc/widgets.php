<?php
/**
 * Register widget area.
 *
 * @package HelpOfAi
 */

function helpofai_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'helpofai' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'helpofai' ),
		'before_widget' => '<section id="%1$s" class="widget glass-panel %2$s" style="padding: 2rem; border-radius: 20px; border: 1px solid var(--glass-border);">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'helpofai_widgets_init' );
