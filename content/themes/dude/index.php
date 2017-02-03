<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package dude
 */

// Start outputting the page
get_header();
get_template_part( 'template-parts/hero', 'blog-main' ); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

    <div class="container container-blog-main">

      <?php if( have_posts() ):
        $i = 1; $y = 1;

        while( have_posts() ):
          the_post();

          if( $i % 2 != 0 ) {
            if( $y % 2 != 0 ) {
              $class = 'mosaic-narrow';
            } else {
              $class = 'mosaic-wide';
            }
          } else {
            if( $y % 2 != 0 ) {
              $class = 'mosaic-wide';
            } else {
              $class = 'mosaic-narrow';
            }

            $y++;
          }

          $i++; ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
            <div class="featured-image"<?php if( has_post_thumbnail() ) : ?> style="background-image:url('<?php echo esc_url(wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>');"<?php endif; ?>>
              <div class="shade"></div>
              <div class="shade shade-extra"></div>

              <div class="blog-excerpt-content">

                <header class="entry-header">
                  <p class="cat"><?php echo get_the_category_list( _x( ' ', 'Used between list items, there is a space after the comma.', 'dude' ) ); ?></p>
                  <?php if( is_single() ) {
                      the_title( '<h1 class="entry-title">', '</h1>' );
                    } else {
                      the_title( '<h2 class="entry-title"><a href="'.esc_url( get_permalink() ).'" rel="bookmark">', '</a></h2>' );
                    }

                  if( 'post' === get_post_type() ): ?>
                    <div class="entry-meta">
                      <p class="entry-time"><time datetime="<?php the_time('c'); ?>"><?php the_time('l') ?>na, <?php the_time('j.n.Y') ?></time></p>
                      <p class="likes"><?php echo file_get_contents( get_theme_file_path( 'svg/likes.svg' ) ); echo dude_get_post_likes( get_the_id() ); ?></p>
                    </div><!-- .entry-meta -->
                  <?php endif; ?>
                </header><!-- .entry-header -->

              <p class="button-wrapper"><a href="<?php the_permalink(); ?>" class="button button-white"><?php _e( 'Lue artikkeli', 'dude' ) ?></a></p>

            </div><!-- .blog-excerpt-content -->
          </div><!-- .featured-image -->

          </article><!-- #post-## -->

        <?php endwhile; ?>

        <article v-bind:id="'post-' + post.post_id" v-bind:class="post.class" v-for="(post, index) in posts">
          <div class="featured-image" v-bind:style="{ backgroundImage: 'url(' + post.thumb_url + ')' }">
            <div class="shade"></div>
            <div class="shade shade-extra"></div>
            <div class="blog-excerpt-content">
              <header class="entry-header">
                <p class="cat" v-html="post.categories">{{ post.categories }}</p>
                <h2 class="entry-title"><a v-bind:href="post.permalink" v-html="post.title">{{ post.title }}</a></h2>
                <div class="entry-meta">
                  <p class="entry-time"><time v-bind:datetime="post.datetime">{{ post.text_time }}</time></p>
                  <p class="likes"><?php echo file_get_contents( get_theme_file_path( 'svg/likes.svg' ) ) ?> {{ post.likes }}</p>
                </div><!-- .entry-meta -->
              </header><!-- .entry-header -->
            <p class="button-wrapper"><a v-bind:href="post.permalink" class="button button-white"><?php _e( 'Lue artikkeli', 'dude' ) ?></a></p>
          </div><!-- .blog-excerpt-content -->
        </div><!-- .featured-image -->
        </article><!-- #post-## -->

      <?php else :
        get_template_part( 'template-parts/content', 'none' );
      endif; ?>

    </div><!-- .container -->

    <div class="container container-posts-navigation">
      <?php the_posts_navigation( array( 'prev_text' => __( 'Lataa lisää artikkeleita', 'dude' ) ) ); ?>
    </div>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
