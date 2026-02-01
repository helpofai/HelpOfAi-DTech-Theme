<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package HelpOfAi
 */

/**
 * Allow SVG Uploads
 */
function helpofai_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'helpofai_mime_types');
