<?php
/*
YARPP Template: Lue lisää -kuvakkeet
Description: Duden lue lisää -osio.
Author: Roni Laukkarinen
*/

if( $related_query->have_posts() ): ?>
  <ol class="related-posts">
    <?php while( $related_query->have_posts() ):
      $related_query->the_post();

      if( has_post_thumbnail() ):
        $img_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )[0];
      endif; ?>

        <li class="col">

          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="featured-image"<?php if( has_post_thumbnail() ): ?> style="background-image:url('<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>');"<?php endif; ?>>
              <div class="shade"></div>
              <div class="shade shade-extra"></div>

              <div class="blog-excerpt-content">

                <header class="entry-header">
                  <p class="cat"><?php echo get_the_category_list( _x( ' ', 'Used between list items, there is a space after the comma.', 'dude' ) ); ?></p>
                  <?php if ( is_single() ) {
                    the_title( '<h1 class="entry-title">', '</h1>' );
                  } else {
                    the_title( '<h2 class="entry-title"><a href="'.esc_url( get_permalink() ).'" rel="bookmark">', '</a></h2>' );
                  }

                  if ( 'post' === get_post_type() ) : ?>
                  <div class="entry-meta">
                    <p class="entry-time"><time datetime="<?php the_time('c'); ?>"><?php the_time('l') ?>na, <?php the_time('j.n.Y') ?></time></p>
                    <p class="likes"><?php echo file_get_contents( get_theme_file_path( 'svg/likes.svg' ) ); echo dude_get_post_likes( get_the_id() ); ?></p>
                  </div><!-- .entry-meta -->
                  <?php
                  endif; ?>
                </header><!-- .entry-header -->

              <p class="button-wrapper"><a href="<?php echo get_the_permalink(); ?>" class="button button-white"><?php _e( 'Lue artikkeli', 'dude' ) ?></a></p>

            </div><!-- .blog-excerpt-content -->
          </div><!-- .featured-image -->

          </article><!-- #post-## -->
        </li>

    <?php endwhile; ?>
  </ol>
  <div style="clear: both"></div>
<?php endif; ?>
