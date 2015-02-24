<?php
// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

// This file returns the options array for the Background Section shortcode metabox
return array(
    __( 'Background Section', 'tiledfourteen' ) => array(
        'elements' => array(
            'background_section' => array(
                'title' => __( 'Background Section', 'tiledfourteen' ),
                'code'  => "[section]<p>&nbsp;</p>[/section]",
                'attributes' => array(
                    array(
                        'type' => 'color',
                        'name' => 'color',
                        'label' => __( 'Text Color', 'tiledfourteen' ),
                        'default' => '',
                        'format' => 'hex',
                    ),
                    array(
                        'type' => 'color',
                        'name' => 'background_color',
                        'label' => __( 'Background Color', 'tiledfourteen' ),
                        'default' => '',
                        'format' => 'hex',
                    ),
                    array(
                        'type' => 'upload',
                        'name' => 'background_image',
                        'label' => __( 'Background Image', 'tiledfourteen' ),
                        'default' => '',
                    ),
                    array(
                        'type' => 'toggle',
                        'name' => 'fixed_background',
                        'label' => __( 'Fix Background Location', 'tiledfourteen' ),
                        'default' => false,
                    ),
                    array(
                        'type' => 'radiobutton',
                        'name' => 'background_size',
                        'label' => __( 'Background Size', 'tiledfourteen' ),
                        'default' => false,
                        'items' => array(
                            array(
                                'label' => __( 'Image Size', 'tiledfourteen' ),
                                'value' => false
                            ),
                            array(
                                'label' => __( 'Cover', 'tiledfourteen' ),
                                'value' => 'cover'
                            ),
                            array(
                                'label' => __( 'Contain', 'tiledfourteen' ),
                                'value' => 'contain'
                            ),
                        )
                    ),
                )
            )

        )
    )
);