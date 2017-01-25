<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package dude
 */

// Start outputting the page
get_header();
get_template_part( 'template-parts/hero', 'blog' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

      <div class="slide slide-single-blog-post">

        <div class="container">

          <?php while( have_posts() ):
            the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

              <div class="entry-content">
                <?php the_content( sprintf(
                    wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'dude' ), array( 'span' => array( 'class' => array() ) ) ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                  ) );

                  wp_link_pages( array(
                    'before' => '<div class="page-links">'.esc_html__( 'Sivut:', 'dude' ),
                    'after'  => '</div>',
                  ) );
                ?>
              </div><!-- .entry-content -->

              <div class="entry-author">
                <?php $user_id = $wpdb->get_results(
                  $wpdb->prepare(
                    "SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = %s AND meta_value = %d",
                    "_linked_user", get_the_author_meta( 'ID' )
                  )
                );

                if( !is_wp_error( $user_id ) && !empty( $user_id ) ):
                  $job_title = get_post_meta( $user_id[0]->post_id, '_job_title', true ); ?>
                  <a href="<?php echo get_the_permalink( $user_id[0]->post_id ) ?>"><?php echo get_avatar( get_the_author_meta( 'email' ), '82' ); ?></a>
                  <h3><?php echo get_the_author_meta( 'display_name' ); ?></h3>
                  <?php if( !empty( $job_title ) ): ?>
                    <h4><?php echo $job_title ?></h4>
                  <?php endif;
                endif; ?>
              </div>

              <footer class="entry-footer">
                <?php dude_entry_footer(); ?>
              </footer><!-- .entry-footer -->

              <div class="entry-actions">

                <div class="social-media-share">
                  <h4><?php _e( 'Jaa ihmessä eteenpäin:', 'dude' ) ?></h4>

                  <a href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;text=<?php echo urlencode( get_the_title().' #digitoimistodude' ) ?>" target="_blank" class="share-twitter">
                    <span class="screen-reader-text"><?php _e( 'Jaa Twitterissä:', 'dude' ) ?> </span><?php echo file_get_contents( get_theme_file_path( 'svg/twitter.svg' ) ); ?>
                  </a>
                  <a href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>" target="_blank" class="share-facebook">
                    <span class="screen-reader-text"><?php _e( 'Jaa Facebookissa:', 'dude' ) ?> </span><?php echo file_get_contents( get_theme_file_path( 'svg/facebook.svg' ) ); ?>
                  </a>
                  <a href="https://telegram.me/share/url?url=<?php the_permalink() ?>&amp;text=<?php echo urlencode( get_the_title() ) ?>" target="_blank" class="share-telegram">
                    <span class="screen-reader-text"><?php _e( 'Jaa Telegrammissa:', 'dude' ) ?> </span><?php echo file_get_contents( get_theme_file_path( 'svg/telegram.svg' ) ); ?>
                  </a>
                  <a href="whatsapp://send?text=<?php echo urlencode( get_the_title() ).' '.get_the_permalink() ?>" data-action="share/whatsapp/share" class="share-whatsapp">
                    <span class="screen-reader-text"><?php _e( 'Jaa WhatsAppissa:', 'dude' ) ?> </span><?php echo file_get_contents( get_theme_file_path( 'svg/whatsapp.svg' ) ); ?>
                  </a>
                </div>

                <div class="dude-likebox">
                  <h4><?php _e( 'Tykkää, jos pidit jutusta:', 'dude' ) ?></h4>
                  <p class="likes" data-id="<?php echo get_the_id() ?>"><?php echo file_get_contents( get_theme_file_path( 'svg/likes.svg' ) ); ?><span><?php echo dude_get_post_likes( get_the_id() ); ?></span></p>
                </div>

                <div class="dude-beerbox">
                  <h4><?php _e( 'Jos rakastit, tee hyvä teko:', 'dude' ) ?></h4>
                  <p><?php printf( __( 'Kaljarahan antamisen sijaan voit <a href="%s" target="_blank">lahjoittaa mielenterveystyöhön', 'dude' ), 'https://donation.securycast.com/mieli?p=10' ) ?></a>.</p>
                </div>

              </div><!-- .entry-actions -->

            </article><!-- #post-## -->

          </div><!-- .container -->

  			</div><!-- .slide -->

        <?php if( function_exists( 'related_entries' ) ): ?>

          <div class="slide slide-related-posts ">
              <div class="container">
                <h2 class="related-title"><?php _e( 'Lue seuraavaksi', 'dude' ) ?></h2>
              </div>

              <div class="container container-related-posts">
              <?php related_entries( array( 'use_template' => true, 'template_file' => 'yarpp-template-jylkkari.php' ) ); ?>
            </div>
          </div>

        <?php endif;

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
          comments_template();
        endif;

      endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
