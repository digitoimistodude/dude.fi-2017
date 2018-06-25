<?php the_post();

// Head content
$alt_title = get_post_meta( get_the_id(), '_alt_title', true );
$svg_logo_filename = get_post_meta( get_the_id(), '_svg_logo_filename', true );

// Optional intro content
$show_general = get_post_meta( get_the_id(), '_show_general', true );
$sub_title_general = get_post_meta( get_the_id(), '_sub_title_general', true );
$site_url = get_post_meta( get_the_id(), '_site_url', true );

// Reference dynamic content
$parts = carbon_get_post_meta( get_the_id(), '_parts', 'complex' );
$text_area_numbering = 1;

// Dynamic css
$css = get_post_meta( get_the_id(), '_custom_css', true );

// Start outputting the page
get_header();

  if( !empty( $css ) ): ?>
    <style><?php echo $css ?></style>
  <?php endif; ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

      <div class="block block-reference">

        <div class="container">

          <header class="reference-header">
            <div class="reference-logo">
              <h1>
                <span class="screen-reader-text"><?php the_title(); ?></span>
                <?php if( locate_template( 'svg/logo-'.$svg_logo_filename.'.svg', false, false ) ) {
                  echo file_get_contents( locate_template( 'svg/logo-'.$svg_logo_filename.'.svg', false, false ) );
                } ?>
              </h1>
            </div>

            <div class="reference-title">
              <div class="reference-header">
                <h2><?php if( !empty( $alt_title ) ):
                  echo $alt_title;
                else:
                  the_title();
                endif; ?></h2>
              </div>
            </div>
          </header>

        </div><!-- .container -->

      </div><!-- .block -->

      <?php if( $show_general ): ?>
        <div class="block block-customer-story">

          <div class="container no-bottom-padding">

            <div class="general-description">
              <?php if( !empty( $sub_title_general ) ): ?>
                <h2><span class="order-number"><?php printf( '%02d', $text_area_numbering ); ?></span> <?php echo $sub_title_general ?></h2>
                <?php $text_area_numbering++;
              endif;

              the_content();

              if( !empty( $site_url ) ): ?>
                <p class="button-wrapper">
                  <a href="<?php echo $site_url ?>" class="button button-with-arrow" target="_blank"><span><?php _e( 'Vieraile sivustolla', 'dude' ); ?></span><?php echo file_get_contents( get_theme_file_path( 'svg/large-cta-arrow.svg' ) ); ?></a>
                </p>
              <?php endif; ?>
            </div><!-- .general-description -->

          </div><!-- .container -->

        </div><!-- .block -->
      <?php endif;

      if( !empty( $parts ) ):
        foreach( $parts as $part ):
          include( locate_template( 'template-parts/reference/p-'.$part['template'].'.php' ) );
        endforeach;
      endif;

      $prev_post = get_previous_post();
      if( !empty( $prev_post ) ): ?>
        <div class="block block-next-reference" style="background-image: url('<?php echo get_the_post_thumbnail_url( $prev_post->ID, 'large' ) ?>');">
          <a href="<?php the_permalink( $prev_post ) ?>">
            <div class="shade"></div>

            <div class="container">
              <h4><?php _e( 'Seuraava työnäyte', 'dude' ) ?></h4>
              <h2><?php echo $prev_post->post_title ?></h2>
            </div>
          </a>
        </div>
      <?php else:
        $newest_reference = get_posts( array(
          'post_type'       => 'reference',
          'posts_per_page'  => 1,
          'fields'          => 'ids'
        ) ); ?>
        <div class="block block-next-reference" style="background-image: url('<?php echo get_the_post_thumbnail_url( $newest_reference[0], 'large' ) ?>');">
          <a href="<?php echo get_post_type_archive_link( 'reference' ) ?>">
            <div class="shade"></div>

            <div class="container">
              <h4><?php _e( 'Tää oli viimeinen, mene tsekkaamaan', 'dude' ) ?></h4>
              <h2><?php _e( 'Kaikki työnäytteet' ) ?></h2>
            </div>
          </a>
        </div>
      <?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
