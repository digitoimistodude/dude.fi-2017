<?php

// References intro content
$page_for_reference = get_option( 'page_for_reference' );
$title = get_the_title( $page_for_reference );
$description = get_post_field( 'post_content', $page_for_reference );
$description = apply_filters( 'the_content', $description );
$description = str_replace( ']]>', ']]&gt;', $description );

// Call to action content
$cta = get_post_meta( $page_for_reference, '_cta_content', true );

// Start outputting the page
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

    <div class="block block-references">

      <div class="container">

        <h1><?php echo $title ?></h1>

        <?php echo $description ?>

      </div>

    </div>

    <?php if( have_posts() ): ?>
      <div class="block block-feed block-feed-reference-page block-content">
        <div class="container">

          <div class="cols cols-references">

            <div class="mosaic-section">

              <?php $i = 1; $y = 1;
              while( have_posts() ):
                the_post();
                include( locate_template( 'template-parts/reference-mosaic-secondary-variable.php' ) );
              endwhile; ?>

            </div><!-- .mosaic-section -->

          </div><!-- .cols -->

        </div><!-- .container -->

      </div><!-- .block-feed -->
    <?php endif;

    if( !empty( $cta ) ): ?>
      <div class="block block-call-to-action">
        <div class="container">
          <?php echo wpautop( $cta ) ?>
        </div>
      </div>
    <?php endif; ?>
	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
