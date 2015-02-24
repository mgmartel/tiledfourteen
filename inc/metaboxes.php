<?php
/**
 * Sets up all theme-specific metaboxes
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

function tiledfourteen_background_metabox_value( $option, $default = null, $post_id = null ) {
    if ( function_exists( 'vp_metabox' ) ) {
        return vp_metabox( 'tiledfourteen_background_metabox.' . $option, $default, $post_id );
    }
    return $default;
}

function tiledfourteen_tiled_header_metabox_value( $option, $default = null, $post_id = null ) {
    if ( function_exists( 'vp_metabox' ) ) {
        return vp_metabox( 'tiledfourteen_tiled_header_metabox.' . $option, $default, $post_id );
    }
    return $default;
}

function tiledfourteen_init_background_metabox() {
    return ( class_exists( 'VP_Metabox' ) ) ? new VP_Metabox( array(
        'id'          => 'tiledfourteen_background_metabox',
        'types'       => array( 'post', 'page' ),
        'title'       => __( 'Page Background', 'wp-tiles' ),
        'priority'    => 'low',
        'context'     => 'side',
        'is_dev_mode' => false,
        'template'    => array(
            array(
                'type'        => 'color',
                'name'        => 'page_text_color',
                'label'       => __( 'Page Text Color', 'wp-tiles' ),
                'description' => __( 'Override Page Text Color', 'wp-tiles' ),
                'default'     => false,
                'format'      => 'hex',
            ),
            array(
                'type'        => 'color',
                'name'        => 'page_background_color',
                'label'       => __( 'Page Background Color', 'wp-tiles' ),
                'description' => __( 'Override Page Background Color', 'wp-tiles' ),
                'default'     => false,
                'format'      => 'hex',
            ),
            array(
                'type'        => 'upload',
                'name'        => 'page_background',
                'label'       => __( 'Page Background Image', 'wp-tiles' ),
                'default'     => false,
                'description' => __( 'Override Page Background Image', 'wp-tiles' )
            ),

            array(
                'type'      => 'group',
                'repeating' => false,
                'length'    => 1,
                'name'      => 'page_background_options',
                'title'     => __( 'Page Background Options', 'wp_tiles' ),
                'fields'    => array(
                    array(
                        'type'  => 'radiobutton',
                        'name'  => 'page_background_repeat',
                        'label' => __( 'Background Repeat' ),
                        'default' => 'repeat',
                        'items' => array(
                            array( 'label' => __('No Repeat'), 'value' => 'no-repeat' ),
                            array( 'label' => __('Tile'), 'value' => 'repeat' ),
                            array( 'label' => __('Tile Horizontally'), 'value' => 'repeat-x' ),
                            array( 'label' => __('Tile Vertically'), 'value' => 'repeat-y' ),
                        ),
                    ),
                    array(
                        'type'  => 'radiobutton',
                        'name'  => 'page_background_position_x',
                        'label' => __( 'Background Position' ),
                        'default' => 'left',
                        'items' => array(
                            array( 'label' => __('Left'), 'value' => 'left' ),
                            array( 'label' => __('Center'), 'value' => 'center' ),
                            array( 'label' => __('Right'), 'value' => 'right' ),
                        ),
                    ),
                    array(
                        'type'  => 'radiobutton',
                        'name'  => 'page_background_attachment',
                        'label' => __( 'Background Attachment' ),
                        'default' => 'scroll',
                        'items' => array(
                            array( 'label' => __('Fixed'), 'value' => 'fixed' ),
                            array( 'label' => __('Scroll'), 'value' => 'scroll' ),
                        ),
                    ),
                ),
                'dependency' => array(
                     'field' => 'page_background',
                    'function' => 'vp_dep_boolean',
                )
            ),

        )
    ) ) : null;
}
add_action( 'after_setup_theme', 'tiledfourteen_init_background_metabox' );

function tiledfourteen_init_tiled_header_metabox() {
    if ( !class_exists( 'VP_Metabox' ) ) return;

    VP_Security::instance()->whitelist_function( 'tiledfourteen_dep_is_images' );
    VP_Security::instance()->whitelist_function( 'tiledfourteen_dep_is_posts' );

    return new VP_Metabox( array(
        'id'          => 'tiledfourteen_tiled_header_metabox',
        'types'       => array( 'post', 'page' ),
        'title'       => __( 'Tiled Header', 'wp-tiles' ),
        'priority'    => 'low',
        'context'     => 'advanced',
        'is_dev_mode' => false,
        'template'    => array(
            array(
                'type' => 'radiobutton',
                'name' => 'tiled_header_type',
                'label' => __( 'Use Tiled Header in place of Featured Image?', 'wp-tiles' ),
                'items' => array(
                    array( 'label' => __( "Don't use tiled header", 'wp-tiles' ), 'value' => 'none' ),
                    array( 'label' => __( 'Images Attached to this post', 'wp-tiles' ), 'value' => 'attached' ),
                    array( 'label' => __( 'Select Images Manually', 'wp-tiles' ), 'value' => 'images' ),
                    array( 'label' => __( 'Custom Query', 'wp-tiles' ), 'value' => 'posts' ),
                ),
                'default' => 'none',
            ),
            array(
                'type' => 'notebox',
                'name' => 'notice_thumbnail',
                'label' => __('Featured Image is Required', 'wp-tiles'),
                'description' => __( 'For this feature to work as expected, you need to make sure you have a featured image as fallback. <strong>Otherwise the tiles may not show up at all.</strong>', 'wp-tiles' ),
                'status' => 'warning',
            ),

            //
            // Image selector
            //

            array(
                'type'      => 'group',
                'repeating' => true,
                'name'      => 'tiled_header_images',
                'title'     => __( 'Images', 'wp_tiles' ),
                'dependency' => array(
                    'field'    => 'tiled_header_type',
                    'function' => 'tiledfourteen_dep_is_images',
                ),
                'fields'    => array(
                    array(
                        'type'        => 'upload',
                        'name'        => 'image',
                        'label'       => __( 'Image', 'wp-tiles' ),
                        'default'     => false,
                    ),
                ),
            ),

            //
            // CUSTOM QUERY
            //

            array(
                'type'      => 'group',
                'repeating' => false,
                'length'    => 1,
                'name'      => 'tiled_header_posts',
                'title'     => __( 'Custom Posts Query', 'wp_tiles' ),
                'dependency' => array(
                    'field'    => 'tiled_header_type',
                    'function' => 'tiledfourteen_dep_is_posts',
                ),
                'fields'    => array_merge( \WPTiles\Admin\Controls::query_basic(), \WPTiles\Admin\Controls::query_basic_more() )
            ),

            //
            // OPTIONS
            //

            array(
                'type' => 'toggle',
                'name' => 'tiled_header_use_custom_options',
                'label' => __( 'Use custom display options instead of defaults for tiled header?', 'wp-tiles' ),
                'default' => false,
            ),

            array(
                'type'      => 'group',
                'repeating' => false,
                'length'    => 1,
                'name'      => 'tiled_header_options',
                'title'     => __( 'Custom Options', 'wp_tiles' ),
                'dependency' => array(
                    'field'    => 'tiled_header_use_custom_options',
                    'function' => 'vp_dep_boolean',
                ),
                'fields'    => array(
                    array(
                        'type'        => 'select',
                        'name'        => 'grid',
                        'label'       => __( 'Grid', 'wp-tiles' ),
                        'description' => __( 'Select which grid to use', 'wp-tiles' ),
                        'default'     => '{{first}}',
                        'items'       => array(
                            'data' => array(
                                array(
                                    'source' => 'function',
                                    'value'  => array( 'WPTiles\Admin\DataSources', 'get_grids' ),
                                ),
                            ),
                        ),
                    ),
                    array(
                        'type' => 'slider',
                        'name' => 'padding',
                        'label' => __('Tile Padding', 'wp-tiles'),
                        'description' => __( 'Padding between the tiles in px', 'wp-tiles'),
                        'min' => '0',
                        'max' => '100',
                        'step' => '1',
                        'default' => wp_tiles()->options->get_defaults( 'padding' ),
                    )
                )
            ),
        )
    ) );
}
add_action( 'after_setup_theme', 'tiledfourteen_init_tiled_header_metabox' );

function tiledfourteen_dep_is_images( $value ) {
    return ( 'images' === $value );
}
function tiledfourteen_dep_is_posts( $value ) {
    return ( 'posts' === $value );
}