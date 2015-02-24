<?php
/**
 * This file contains all functions for outputting custom CSS in the header of the
 * theme. The amount of custom CSS is limited, so to prevent much ado about little
 * performance gain, CSS is outputted on the page.
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

function tiledfourteen_get_mod_or_metabox( $option, $group = false, $group_offset = 0, $default = null ) {
    $mod  = get_theme_mod( 'tiledfourteen_' . $option, $default );
    $meta = tiledfourteen_background_metabox_value( $group ? "$group.$group_offset.$option" : $option );

    return ( $meta ) ? $meta : $mod;
}

function tiledfourteen_custom_css() {
    $styles = '';

    $modify_color = function( $color_code, $amount ) {

        $hex = str_replace( "#", "", $color_code );
        $r   = (strlen( $hex ) == 3) ? hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) ) : hexdec( substr( $hex, 0, 2 ) );
        $g   = (strlen( $hex ) == 3) ? hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) ) : hexdec( substr( $hex, 2, 2 ) );
        $b   = (strlen( $hex ) == 3) ? hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) ) : hexdec( substr( $hex, 4, 2 ) );
        $r   = round( $r + $amount );
        $g   = round( $g + $amount );
        $b   = round( $b + $amount );

        return "#" . str_pad( dechex( max( 0, min( 255, $r ) ) ), 2, "0", STR_PAD_LEFT )
            . str_pad( dechex( max( 0, min( 255, $g ) ) ), 2, "0", STR_PAD_LEFT )
            . str_pad( dechex( max( 0, min( 255, $b ) ) ), 2, "0", STR_PAD_LEFT );
    };

    // Custom base styles
    $base_color = get_theme_mod( 'tiledfourteen_base_color' );
    if ( $base_color && '#24890d' !== $base_color ) {
        $props = array(
            'primary_color' => $base_color,
            'hover_color'   => $modify_color( $base_color, '10' ),
            'active_color'  => $modify_color( $base_color, '20' ),
        );
        $styles .=  include( get_stylesheet_directory() . '/inc/styles-base-color.php' );
    }

    // Custom page text color
    $text_color = strtolower( tiledfourteen_get_mod_or_metabox( 'page_text_color' ) );
    if ( $text_color && '#2b2b2b' !== $text_color ) {
        $light_color = $modify_color( $text_color, 75 );

        // If light color is completely white, try darkening instead
        if ( $light_color === '#ffffff' )
            $light_color = $modify_color( $text_color, -75 );

        $styles .= "body,button,input,select,textarea,"
            . "blockquote cite,blockquote small,"
            . ".entry-title a,"
            . ".cat-links a,"
            . ".post-navigation a,.image-navigation a,"
            . ".paging-navigation a,.paging-navigation a:hover,"
            . ".comment-author a,.comment-reply-title small a"
            . "{color:$text_color;}";

        $styles .= "blockquote,del,.wp-caption,.entry-meta,.entry-meta a,"
            . ".entry-content .edit-link a,"
            . ".post-navigation .meta-nav,"
            . ".taxonomy-description,.author-description,"
            . ".comment-list .trackback a,.comment-list .pingback a,.comment-metadata a,"
            . ".comment-notes,.comment-awaiting-moderation,.logged-in-as,.no-comments,"
            . ".form-allowed-tags,.form-allowed-tags code "
            . "{color:$light_color;}";
    }

    // Custom page background color
    $page_bg = strtolower( tiledfourteen_get_mod_or_metabox( 'page_background_color' ) );
    if ( $page_bg && !in_array( $page_bg, array( '#fff', '#ffffff' ) ) ) {
        $styles .= ".site,"
            . ".site-content .entry-header,"
            . ".site-content .entry-content,.site-content .entry-summary,.page-content,"
            . ".site-content .entry-meta"
            . "{background-color:$page_bg;}";
    }

    // Custom page background image
    $page_bg_img = tiledfourteen_get_mod_or_metabox( 'page_background' );
    if ( $page_bg_img ) {
        $styles .= ".site"
            . "{background: url('$page_bg_img');";

        $repeat = tiledfourteen_get_mod_or_metabox( 'page_background_repeat', 'page_background_options' );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$styles .= "background-repeat: $repeat;";

		$position = tiledfourteen_get_mod_or_metabox( 'page_background_position_x', 'page_background_options' );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$styles .= "background-position: top $position;";

		$attachment = tiledfourteen_get_mod_or_metabox( 'page_background_attachment', 'page_background_options' );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$styles .= "background-attachment: $attachment;";

        $styles .= "}";
    }

    // Custom max-width
    $max_width = (int) get_theme_mod( 'tiledfourteen_max_width', false );
    if ( $max_width && 1600 !== $max_width ) {
        $styles .= ".site,.site-header{max-width:{$max_width}px;}";
    }

    // Custom content max-width
    $content_max_width = (int) get_theme_mod( 'tiledfourteen_content_max_width', false );
    if ( $content_max_width && 800 !== $content_max_width ) {
        $styles .= ".site-content .entry-header,.site-content .entry-content,.site-content .entry-summary,.site-content .entry-meta,.page-content,"
                .  ".post-navigation,.image-navigation,.archive-header,.page-header,.contributor-info,.comments-area,.site-main .mu_register,"
                .  ".widecolumn > h2,.widecolumn > form{max-width:{$content_max_width}px;}";
    }

    if ( get_theme_mod( 'tiledfourteen_center_site' ) ) {
        $styles .= ".site{margin: 0 auto;}";
    }

    if ( $styles ) {
        if ( !defined( 'SCRIPT_DEBUG' ) || !SCRIPT_DEBUG )
            $styles = tiledfourteen_minify_css( $styles );

        echo "<style> " . $styles . "</style>";
    }

}
add_action( 'wp_head', 'tiledfourteen_custom_css' );

/**
 * @see http://stackoverflow.com/a/8593165
*/
function tiledfourteen_minify_css( $css ) {

    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
    $css = str_replace('{ ', '{', $css);
    $css = str_replace(' }', '}', $css);
    $css = str_replace('; ', ';', $css);

    return $css;

}


/**
 * Use below function for modify_color to use percentage instead of amount
 */
//    $modify_color = function( $color_code, $percentage ) {
//        $percentage_adjuster = round( $percentage / 100, 2 );
//
//        $hex = str_replace( "#", "", $color_code );
//        $r   = (strlen( $hex ) == 3) ? hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) ) : hexdec( substr( $hex, 0, 2 ) );
//        $g   = (strlen( $hex ) == 3) ? hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) ) : hexdec( substr( $hex, 2, 2 ) );
//        $b   = (strlen( $hex ) == 3) ? hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) ) : hexdec( substr( $hex, 4, 2 ) );
//        $r   = round( $r - ($r * $percentage_adjuster) );
//        $g   = round( $g - ($g * $percentage_adjuster) );
//        $b   = round( $b - ($b * $percentage_adjuster) );
//
//        return "#" . str_pad( dechex( max( 0, min( 255, $r ) ) ), 2, "0", STR_PAD_LEFT )
//            . str_pad( dechex( max( 0, min( 255, $g ) ) ), 2, "0", STR_PAD_LEFT )
//            . str_pad( dechex( max( 0, min( 255, $b ) ) ), 2, "0", STR_PAD_LEFT );
//    };