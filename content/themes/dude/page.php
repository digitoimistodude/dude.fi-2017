<?php

// Start outputting the page
get_header();
get_template_part( 'template-parts/hero', 'page' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
      <div class="block block-single-blog-post">

        <div class="container" style="padding-bottom:8rem;">

          <?php while( have_posts() ):
            the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

              <div class="entry-content">
                <?php the_content( sprintf(
                    wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'dude' ), array( 'span' => array( 'class' => array() ) ) ),
                    the_title( '<span class="screen-reader-text">"', '"</span>', false )
                  ) ); ?>
              </div><!-- .entry-content -->
            </article>
          <?php endwhile; ?>
        </div>
      </div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
