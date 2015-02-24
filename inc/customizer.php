<?php
/**
 * Add Theme Customizer Settings
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

function tiledfourteen_customize_register( $wp_customize ) {

    //
    // THEME BASE COLOR
    //

    $wp_customize->add_setting(
    'tiledfourteen_base_color',
        array(
            'default' => '#24890d',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'tiledfourteen_base_color',
            array(
                'label' => __( 'Theme Base Color', 'tiledfourteen' ),
                'section' => 'colors',
                'settings' => 'tiledfourteen_base_color',
                'priority' => 5
            )
        )
    );

    //
    // CONTENT BACKGROUND AND TEXT COLOR
    //

    $wp_customize->add_setting(
    'tiledfourteen_page_background_color',
        array(
            'default' => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'tiledfourteen_page_background_color',
            array(
                'label' => __( 'Default Page Background Color', 'tiledfourteen' ),
                'section' => 'colors',
                'settings' => 'tiledfourteen_page_background_color',
                'priority' => 20
            )
        )
    );

    $wp_customize->add_setting(
    'tiledfourteen_page_text_color',
        array(
            'default' => '#2b2b2b',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'tiledfourteen_page_text_color',
            array(
                'label' => __( 'Default Page Text Color', 'tiledfourteen' ),
                'section' => 'colors',
                'settings' => 'tiledfourteen_page_text_color',
                'priority' => 30
            )
        )
    );

    $wp_customize->add_section( 'page_background_image', array(
        'title'          => __( 'Page Background Image' ),
        'priority'       => 90, // Background Image is 80, Nav is 100
    ) );

    $wp_customize->add_setting( 'tiledfourteen_page_background' );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'tiledfourteen_page_background',
            array(
                'label'    => 'Page Background Image',
                'section'  => 'page_background_image',
                'settings' => 'tiledfourteen_page_background'
            )
        )
    );

    $wp_customize->add_setting( 'page_background_repeat', array(
        'default'        => 'repeat',
        'theme_supports' => 'custom-background',
    ) );

    $wp_customize->add_control( 'page_background_repeat', array(
        'label'      => __( 'Background Repeat' ),
        'section'    => 'page_background_image',
        'type'       => 'radio',
        'choices'    => array(
            'no-repeat'  => __('No Repeat'),
            'repeat'     => __('Tile'),
            'repeat-x'   => __('Tile Horizontally'),
            'repeat-y'   => __('Tile Vertically'),
        ),
    ) );

    $wp_customize->add_setting( 'page_background_position_x', array(
        'default'        => 'left',
        'theme_supports' => 'custom-background',
    ) );

    $wp_customize->add_control( 'page_background_position_x', array(
        'label'      => __( 'Background Position' ),
        'section'    => 'page_background_image',
        'type'       => 'radio',
        'choices'    => array(
            'left'       => __('Left'),
            'center'     => __('Center'),
            'right'      => __('Right'),
        ),
    ) );

    $wp_customize->add_setting( 'page_background_attachment', array(
        'default'        => 'fixed',
        'theme_supports' => 'custom-background',
    ) );

    $wp_customize->add_control( 'page_background_attachment', array(
        'label'      => __( 'Background Attachment' ),
        'section'    => 'page_background_image',
        'type'       => 'radio',
        'choices'    => array(
            'fixed'      => __('Fixed'),
            'scroll'     => __('Scroll'),
        ),
    ) );

    //
    // FEATURED CONTENT TILES
    //

    $wp_customize->remove_setting( 'featured_content_layout' );
    $wp_customize->remove_control( 'featured_content_layout' );

	// Grids
    $grids = wp_tiles()->get_grids();
    $default = wp_tiles()->get_default_grid_title();

    $choices = array();
    foreach( array_keys( $grids ) as $grid ) {
        $choices[esc_attr( $grid )] = esc_html( $grid );
    }

	// Add the featured content layout setting and control.
	$wp_customize->add_setting( 'wp_tiles_featured_content_layout', array(
		'default'           => 'tiles',
		'sanitize_callback' => 'tiledfourteen_sanitize_layout',
	) );

	$wp_customize->add_control( 'wp_tiles_featured_content_layout', array(
		'label'   => __( 'Type', 'tiledfourteen' ),
		'section' => 'featured_content',
		'type'    => 'select',
		'choices' => array(
			'tiles'  => __( 'Tiles',   'tiledfourteen' ),
			'grid'   => __( 'Grid',   'twentyfourteen' ),
			'slider' => __( 'Slider', 'twentyfourteen' ),
		),
        'priority' => 5,
	) );

	$wp_customize->add_setting( 'wp_tiles_featured_content_grid', array(
		'default'           => $default,
		'sanitize_callback' => 'tiledfourteen_sanitize_grid',
	) );

	$wp_customize->add_control( 'wp_tiles_featured_content_grid', array(
		'label'   => __( 'Grid', 'twentyfourteen' ),
		'section' => 'featured_content',
		'type'    => 'select',
		'choices' => $choices,
        'priority' => 10
	) );


    //
    // LAYOUT OPTIONS
    //
	$wp_customize->add_section( 'tiledfourteen_options' , array(
       'title'      => __('Layout Options','tiledfourteen'),
	   'description' => __( 'Use the settings below to tweak the size and positioning of your website.', 'tiledfourteen' ),
       'priority'   => 30,
    ) );

    // Set the max width
	$wp_customize->add_setting(
        'tiledfourteen_max_width',
        array(
            'default' => 1600,
            'sanitize_callback' => 'absint'
        )
    );

	$wp_customize->add_control(
        'tiledfourteen_max_width',
        array(
            'label' => __('Set site max-width (default is 1600).','tiledfourteen'),
            'section' => 'tiledfourteen_options',
            'priority' => 10,
            'type' => 'text',
        )
    );

    // Set the content max width
	$wp_customize->add_setting(
        'tiledfourteen_content_max_width',
        array(
            'default' => 800,
            'sanitize_callback' => 'absint'
        )
    );

	$wp_customize->add_control(
        'tiledfourteen_content_max_width',
        array(
            'label' => __('Set content max-width (default is 800).','tiledfourteen'),
            'section' => 'tiledfourteen_options',
            'priority' => 20,
            'type' => 'text',
        )
    );

    // Center Site
    $wp_customize->add_setting(
        'tiledfourteen_center_site', array (
			'sanitize_callback' => 'tiledfourteen_sanitize_checkbox',
		)
    );

    $wp_customize->add_control(
        'tiledfourteen_center_site',
        array(
            'type'     => 'checkbox',
            'label'    => __('Center Website', 'tiledfourteen'),
            'section'  => 'tiledfourteen_options',
            'priority' => 30,
            'default'  => 1
        )
    );

    //
    // LOGO
    //
    $wp_customize->add_setting( 'tiledfourteen_logo' );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'tiledfourteen_logo', array(
        'label'    => __( 'Upload Logo (replaces text)', 'tiledfourteen' ),
        'section'  => 'title_tagline',
        'settings' => 'tiledfourteen_logo',
    ) ) );

    //
    // EXTRA SCRIPTS
    //
	$wp_customize->add_section( 'tiledfourteen_scripts' , array(
       'title'      => __('Advanced Scripts','tiledfourteen'),
	   'description' => __( 'TiledFourteen comes bundled with some extra scripts to add some extra pizazz to your site.', 'tiledfourteen' ),
       'priority'   => 50,
    ) );

    // Set the max width
	$wp_customize->add_setting(
        'tiledfourteen_instantclick',
        array(
            'default' => 1,
            'sanitize_callback' => 'tiledfourteen_sanitize_checkbox'
        )
    );

	$wp_customize->add_control(
        'tiledfourteen_instantclick',
        array(
            'label' => __('InstantClick','tiledfourteen'),
            'section' => 'tiledfourteen_scripts',
            'priority' => 10,
            'type' => 'checkbox',
        )
    );

}
add_action( 'customize_register', 'tiledfourteen_customize_register', 11 );

/**
 * Sanitize Featured Content Grid layout value
 * @param string $grid
 * @return string Title of existing grid
 */
function tiledfourteen_sanitize_grid( $grid ) {
    if ( !wp_tiles()->get_grids( $grid ) ) {
        $grid = wp_tiles()->get_default_grid_title();
    }

    return $grid;
}

/**
 * Sanitize the Featured Content layout value.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param string $layout Layout type.
 * @return string Filtered layout type (grid|slider).
 */
function tiledfourteen_sanitize_layout( $layout ) {
	if ( ! in_array( $layout, array( 'tiles', 'grid', 'slider' ) ) ) {
		$layout = 'tiles';
	}

	return $layout;
}

/**
 * Sanitize checkbox
 */
function tiledfourteen_sanitize_checkbox( $input ) {
    return ( 1 == $input ) ? 1 : 0;
}