<?php
/**
 * Loads all extra scripts for TiledFourteen
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

require 'instantclick/class-wp-instantclick.php';

function tiledfourteen_init_scripts() {
    if ( get_theme_mod( 'tiledfourteen_instantclick' ) ) {
        WP_InstantClick::enable();
    }
}
add_action( 'wp_enqueue_scripts', 'tiledfourteen_init_scripts' );
