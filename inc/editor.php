<?php
/**
 * Add extra classes to editor
 */

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

// Add styleselect button to editor
add_filter( 'mce_buttons_2', function( $buttons ){
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
} );

// Set button contents
add_filter( 'tiny_mce_before_init', function( $init_array ) {
	$style_formats = array(
		array(
			'title' => '.statement quote',
			'block' => 'blockquote',
			'classes' => 'statement',
			'wrapper' => true,
            'styles' => array(
                'color'         => 'green',
                'fontWeight'    => 'bold',
                'textTransform' => 'uppercase'
            )
		),
		array(
			'title' => '⇠.rtl',
			'block' => 'blockquote',
			'classes' => 'rtl',
			'wrapper' => true,
		),
		array(
			'title' => '.ltr⇢',
			'block' => 'blockquote',
			'classes' => 'ltr',
			'wrapper' => true,
		),
	);

    // Completely override all other style formats, because we'd be stuck with
    // *all* Headings, Bold, Italics, etc. as well (sorry other plugins..)
	$init_array['style_formats'] = json_encode( $style_formats );

	return $init_array;
});