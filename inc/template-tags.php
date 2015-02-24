<?php

// Exit if accessed directly
if ( !defined ( 'ABSPATH' ) )
    exit;

function tiledfourteen_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

    $tiled_header = tiledfourteen_tiled_header_metabox_value( 'tiled_header_type' );

    if ( is_singular() && in_array( $tiled_header, array( 'attached', 'posts', 'images' ) ) ) {

        $use_carousel = ( class_exists( 'No_Jetpack_Carousel' ) || class_exists( 'Jetpack_Carousel' )
            && !apply_filters( 'jp_carousel_maybe_disable', false ) );

        $opts = array(
            'pagination' => false,
            'breakpoint' => 0,
            'link' => $use_carousel ? 'carousel' : 'thickbox'
        );

        if ( tiledfourteen_tiled_header_metabox_value( 'tiled_header_use_custom_options' ) ) {
            $options = tiledfourteen_tiled_header_metabox_value( 'tiled_header_options.0' );

            $opts['grids'] = array( (int) $options['grid'] );
            $opts['padding'] = (int) $options['padding'];

        } else {
            // Here's a nice default header grid
            $opts['grids'] = array(
                "AA.BCCEE",
                "AA.BDDEE"
            );

        }

        if ( 'images' === $tiled_header ) {

            $images = tiledfourteen_tiled_header_metabox_value( 'tiled_header_images' );
            $images = array_filter( wp_list_pluck( $images, 'image' ) );

            $posts = _tiledfourteen_get_image_ids( $images );

            if ( empty( $posts ) )
                return twentyfourteen_post_thumbnail();

            $opts_string = "";
            foreach( $opts as $key => $opt ) {

                if ( is_array( $opt ) )
                    $opt = implode( ',', $opt );

                $opts_string .= " $key='$opt'";
            }
            echo do_shortcode( "[gallery ids='" . implode( ',', $posts ) . "' tiles=true $opts_string]" );
            return;

        }

        if ( 'attached' === $tiled_header ) {
            $opts['link'] = 'none'; // @todo Carousel or Thickbox?
            $opts['byline_height'] = 0;

            $query = array(
                'post_parent'    => get_the_ID(),
                'post_type'      => 'attachment',
                'post_status'    => 'inherit',
                'posts_per_page' => 'auto'
            );

        } elseif ( 'posts' === $tiled_header ) {
            $opts['link'] = 'post';

            $query = tiledfourteen_tiled_header_metabox_value( 'tiled_header_posts.0' );

            if ( !$query || empty( $query ) )
                $query = array(); // Fallback to defaults

        }

        $query   = apply_filters( 'tiledfourteen_tiled_header_query', $query, $tiled_header );
        $options = apply_filters( 'tiledfourteen_tiled_header_options', $options, $tiled_header );

        if ( the_wp_tiles( $query, $opts ) )
            return;

    }

    // Fires when no posts are found for the tiles, this is not a single post, or of cource, tiles are disabled
    return twentyfourteen_post_thumbnail();
}

    /**
     * Unfortunately, our options framework (vafpress-framework - which is awesome
     * in every other aspect!) returns image urls instead of ids. This function
     * converts those urls into an array of ids using a single DB query. Not pretty,
     * but 'good enough'.
     */
    function _tiledfourteen_get_image_ids( $image_urls ) {
            global $wpdb;

            // Get the upload directory paths
            $upload_dir_paths = wp_upload_dir();

            $urls = $attachment_ids = array();
            foreach( $image_urls as $attachment_url ) {
                // If there is no url, return.
                if ( '' == $attachment_url || false === strpos( $attachment_url, $upload_dir_paths['baseurl'] ) )
                    continue;

                // If this is the URL of an auto-generated thumbnail, get the URL of the original image
                $attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );

                // Remove the upload path base directory from the attachment URL
                $attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );

                $urls[] = $attachment_url;
            }

            if ( empty( $urls ) ) return array();

            $urls = esc_sql( $urls );
            $meta_value_in_string = "'" . implode( "','", $urls ) . "'";

            $attachment_ids = $wpdb->get_col(
                "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE 1=1 "
                . "AND wposts.ID = wpostmeta.post_id "
                . "AND wpostmeta.meta_key = '_wp_attached_file' "
                . "AND wpostmeta.meta_value IN ($meta_value_in_string) "
                . "AND wposts.post_type = 'attachment'"
            );

            return $attachment_ids;
    }