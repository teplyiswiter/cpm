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

function xmag_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
                esc_attr( get_the_date( 'c' ) ),
                esc_html( get_the_date() ),
                esc_attr( get_the_modified_date( 'c' ) ),
                esc_html( get_the_modified_date() )
        );      
        
        $posted_on = sprintf(
                _x( '<span class="icon-clock"></span> %s', 'post date', 'xmag' ),
                '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>';
        
}

?>
