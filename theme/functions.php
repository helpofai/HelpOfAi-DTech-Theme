<?php
/**
 * HelpOfAi functions and definitions
 *
 * @package HelpOfAi
 */

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Register widget area.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Custom Theme Options.
 */
require get_template_directory() . '/inc/theme-options.php';

/**
 * Custom functions and extensions.
 */
require get_template_directory() . '/inc/extras.php';