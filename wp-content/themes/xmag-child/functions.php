<?php
/**
 * Theme functions and definitions
 *
 * @package xMag
 * @since xMag 1.0
 */

/**
 * Enqueues scripts and styles.
 */
function xmag_child_scripts() {
   wp_enqueue_style( 'parent-xmag-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'xmag_child_scripts' );
?>