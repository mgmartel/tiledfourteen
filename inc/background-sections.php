<?php
add_shortcode( 'section', array( 'BackgroundSection_Shortcode', 'do_shortcode' ) );
BackgroundSection_Shortcode::setup_editor_button();

class BackgroundSection_Shortcode
{
    private static $id = 1;

    public static function do_shortcode( $atts = array(), $content = '' ) {
        $div_atts = shortcode_atts( array(
            'background_color' => false,
            'background_image' => false,
            'background_attachment' => false,
            'background_size'  => false,
            'fixed_background' => false
        ), $atts );

        $fg_atts = shortcode_atts( array(
            'color' => false
        ), $atts );

        if ( $div_atts['fixed_background'] )
            $div_atts['background_attachment'] = 'fixed';

        unset( $div_atts['fixed_background'] );

        if ( $div_atts['background_image'] ) {
            $div_atts['background_image'] = "url('{$div_atts['background_image']}')";
        }

        $div_atts = array_filter( $div_atts );
        $fg_atts  = array_filter( $fg_atts );

        $ret = "";
        $id = self::$id++;

        if ( !empty( $div_atts ) || !empty( $fg_atts ) ) {
            $ret .= "<style>";

            if ( !empty( $div_atts ) ) {
                $ret .= "#background-section-$id:before{";

                foreach( $div_atts as $key => $value ) {
                    $key = str_replace( '_', '-', $key );
                    $ret .= "$key:$value;";
                }

                $ret .= "}";
            }
            if ( !empty( $fg_atts ) ) {

                $ret .= "#background-section-$id{";

                foreach( $fg_atts as $key => $value ) {
                    $ret .= "$key:$value;";
                }
                $ret .= "}";

            }

            $ret .= "</style>";
        }

        $ret .= "<div class='background-section' id='background-section-$id'>" . do_shortcode( $content ) . "</div>";

        return $ret;
    }

    public static function setup_editor_button() {
            return new \VP_ShortcodeGenerator( array(
                'name'           => 'background_section_shortcode',
                'template'       => plugin_dir_path( __FILE__ ) . 'background-sections-shortcode-options.php',
                'modal_title'    => __( 'Background Section Shortcode', 'wp-tiles' ),
                'button_title'   => __( 'Background Section', 'wp-tiles' ),
                'types'          => array( '*' ),
                'main_image'     => VP_IMAGE_URL . '/vp_shortcode_icon.png',
                'sprite_image'   => VP_IMAGE_URL . '/vp_shortcode_icon_sprite.png',
            ) );
    }

}