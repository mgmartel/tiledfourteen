<?php

// Check for updates
require get_stylesheet_directory() . '/inc/updater.php';

// Modify Theme Customizer functionality.
require get_stylesheet_directory() . '/inc/customizer.php';

// Add Metaboxes
require get_stylesheet_directory() . '/inc/metaboxes.php';

// Custom CSS
require get_stylesheet_directory() . '/inc/custom-css.php';

// Scripts
require get_stylesheet_directory() . '/inc/scripts.php';

// Add Template Tags
require get_stylesheet_directory() . '/inc/template-tags.php';

// Add Style to editor
require get_stylesheet_directory() . '/inc/editor.php';

// Add Background Sections shortcode.
if ( class_exists( 'VP_ShortcodeGenerator' ) )
    require get_stylesheet_directory() . '/inc/background-sections.php';

if ( !defined( 'WP_TILES_VERSION' ) )
    return;

if ( ! isset( $content_width ) ) {
    // Content width influences the 'large' image size. TwentyFourteen sets it
    // particularly small, but we want it to independent of theme size, because
    // it's a sweet tile size
	$content_width = 0;
}

// Body classes
function tiledfourteen_body_classes( $classes ) {
    if ( is_page_template( 'page-templates/no-sidebars.php' ) ) {
        $classes[] = 'no-sidebars';
        $classes[] = 'full-width';
    }

    return $classes;
}
add_filter( 'body_class', 'tiledfourteen_body_classes', 15 );

// Theme setup
function tiledfourteen_setup() {
    $max_posts = 6;
    if ( 'tiles' == get_theme_mod( 'wp_tiles_featured_content_layout' ) && function_exists( 'wp_tiles' ) ) {
        $grids = wp_tiles()->get_grids( get_theme_mod( 'wp_tiles_featured_content_grid' ) );
        $grid = reset( $grids );

        // Get number of posts in grid
        if ( $grid ) {
            $max_posts = wp_tiles()->get_posts_in_grid( $grid );
        }
    }

	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'twentyfourteen_get_featured_posts',
		'max_posts' => $max_posts,
	) );

    add_theme_support( 'wp-tiles-full-width' );
}
add_action( 'after_setup_theme', 'tiledfourteen_setup', 11 );


// Allow font icons on tiles
add_filter( 'wp_tiles_byline_tags', function( $tags, $post, $template ) {
    if ( strpos( $template, '%icon%' ) !== false ) {
        $tags['%icon%'] = "";

        $icon = get_post_meta( $post->ID, 'post-featured-icon', true );
        if ( $icon ) {
            $icon_classes = implode( " ", explode( '|', $icon ) );
            $tags['%icon%'] = "<span><i class='$icon_classes'></i></span>";
        }

    }

    return $tags;
}, 10, 3 );

add_filter( 'wp_tiles_byline_tags_dynamic', function( $ret, $tag, $arg, $post ) {
    if ( $ret !== false || 'icon' !== $tag)
        return $ret;

    if ( $icon = get_post_meta( $post->ID, 'post-featured-icon', true ) ) {
        $icon_classes = implode( " ", explode( '|', $icon ) );
        return "<i class='$icon_classes $arg'></i>";
    }

    return '';
}, 10, 4 );

// Allow SVG uploads
add_filter( 'upload_mimes', function( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
} );

// SVG Fix for post thumbnails and media library
add_action('admin_head', function(){
  echo '<style type="text/css">td.media-icon img[src$=".svg"], .attachment-post-thumbnail[src$=".svg"] { width: 100% !important; height: auto !important; }</style>';
});

// Make tiled featured-image replacement use the 'has-post-thumbnail' class
function tiledfourteen_post_classes( $classes ) {
    $tiled_header = tiledfourteen_tiled_header_metabox_value( 'tiled_header_type' );

    if ( is_singular() && in_array( $tiled_header, array( 'attached', 'posts', 'images' ) ) && !has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
    }

	return $classes;
}
add_filter( 'post_class', 'tiledfourteen_post_classes' );