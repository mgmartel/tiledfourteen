<?php
/**
 * The template for displaying featured content
 *
 * @uses tiledfourteen_post_thumbnail()
 * @package TiledFourteen
 * @since TiledFourteen 1.0
 */
?>

<div id="featured-content" class="featured-content">
	<div class="featured-content-inner">
	<?php
		/**
		 * Fires before the Twenty Fourteen featured content.
		 *
		 * @since Twenty Fourteen 1.0
		 */
		do_action( 'twentyfourteen_featured_posts_before' );

		$featured_posts = twentyfourteen_get_featured_posts();

        if ( 'tiles' == get_theme_mod( 'wp_tiles_featured_content_layout' ) ) :
            if ( function_exists( 'the_wp_tiles' ) ) {
                $grid = get_theme_mod( 'wp_tiles_featured_content_grid' );

                // Use these filters for finegrained control over the featured posts grid
                $featured_posts = apply_filters( 'tiledfourteen_featured_posts', $featured_posts );
                $options = apply_filters( 'tiledfourteen_featured_posts_options', array(
                    'grids' => $grid
                ) );

                the_wp_tiles( $featured_posts, $options );
            };

        else :
            foreach ( (array) $featured_posts as $order => $post ) :
                setup_postdata( $post );

                 // Include the featured content template.
                get_template_part( 'content', 'featured-post' );
            endforeach;

        endif;

		/**
		 * Fires after the Twenty Fourteen featured content.
		 *
		 * @since Twenty Fourteen 1.0
		 */
		do_action( 'twentyfourteen_featured_posts_after' );

		wp_reset_postdata();
	?>
	</div><!-- .featured-content-inner -->
</div><!-- #featured-content .featured-content -->
