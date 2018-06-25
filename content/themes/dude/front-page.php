<?php the_post();

// Hero content
$hero_title = get_post_meta( get_the_id(), '_fp_hero_title', true );
$hero_content = get_post_meta( get_the_id(), '_fp_hero_content', true );
$hero_button = get_post_meta( get_the_id(), '_fp_hero_button', true );
$hero_button_url = get_post_meta( get_the_id(), '_fp_hero_button_url', true );

// Services content
$wp_page_id = get_post_meta( get_the_id(), '_fp_wordpress_page_id', true );
$wc_page_id = get_post_meta( get_the_id(), '_fp_woocommerce_page_id', true );

// Other additional content
$references_title = get_post_meta( get_the_id(), '_fp_references_title', true );
$clients_title = get_post_meta( get_the_id(), '_fp_clients_title', true );
$blog_title = get_post_meta( get_the_id(), '_fp_blog_title', true );

// Start outputting the content
get_header(); ?>

	<div class="content-area">
		<main id="main" class="site-main">

      <div class="block block-first block-front-page" <?php if ( has_post_thumbnail() ) : ?> style="background-image:url('<?php echo esc_url(wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>');"<?php endif; ?>>
        <div class="shade"></div>
        <div class="shade shade-extra"></div>

        <div class="container container-centered">
          <?php if( !empty( $hero_title ) ): ?>
            <h1><?php echo $hero_title ?></h1>
          <?php endif;

          if( !empty( $hero_content ) ):
            echo wpautop( $hero_content );
          endif;

          if( !empty( $hero_button ) && !empty( $hero_button_url ) ): ?>
            <p><a href="<?php echo $hero_button_url ?>" class="button button-white button-with-arrow"><span><?php echo $hero_button ?></span><?php echo file_get_contents( get_theme_file_path( 'svg/large-cta-arrow.svg' ) ); ?></a></p>
          <?php endif; ?>

        </div><!-- .container -->

        <div class="scroll-down">
          <a href="#"><span class="screen-reader-text"><?php _e( 'Linkki, jota klikkaamalla näyttö rullaa seuraavaan sisältöön', 'dude' ); ?></span></a>
            <p><?php _e( 'Alaspäinkin pääsee', 'dude' ); ?></p>
            <p><?php echo file_get_contents( get_theme_file_path( 'svg/angle-down.svg' ) ); ?></p>          
        </div>

      </div><!-- .block -->


      <div id="primary" class="block block-content block-content-services scroll-down-anchor">

        <div class="container">

          <div class="cols">

            <div class="col col-description">
              <?php the_content() ?>
            </div><!-- .col -->

            <div class="col col-icons">

              <?php if( !empty( $wp_page_id ) ): ?>
                <div class="col-dawg col-wordpress">

                  <a href="<?php the_permalink( $wp_page_id ) ?>">
                    <?php echo file_get_contents( esc_url( get_stylesheet_directory().'/svg/wordpress-full.svg' ) ); ?>
                    <h3><?php echo get_the_title( $wp_page_id ) ?></h3>
                  </a>

                </div><!-- .col-dawg -->
              <?php endif;

              if( !empty( $wc_page_id ) ): ?>
                <div class="col-dawg col-woocommerce">

                  <a href="<?php the_permalink( $wc_page_id) ?>">
                    <?php echo file_get_contents( esc_url( get_stylesheet_directory().'/svg/woocommerce-full.svg' ) ); ?>
                    <h3><?php echo get_the_title( $wc_page_id ) ?></h3>
                  </a>

                </div><!-- .col-dawg -->
              <?php endif; ?>

            </div><!-- .col -->

          </div><!-- .cols -->

        </div><!-- .container -->

      </div><!-- .block-content-services -->


      <?php if( !empty( $references_title ) || !empty( $clients_title ) ): ?>
        <div class="block block-feed block-content">

          <?php if( !empty( $references_title ) ): ?>
            <div class="container">

              <h2><?php echo $references_title ?></h2>

            </div>

            <div class="container">

              <div class="cols cols-references">

                <div class="mosaic-section">

                  <?php $exclude = array();
                  $query = new WP_Query( array(
                    'post_type'               => 'reference',
                    'post_status'             => 'publish',
                    'posts_per_page'          => 1,
                    'meta_query'              => array(
                      'relation'  => 'AND',
                      array(
                        'key'   => '_pool_upsell',
                      ),
                      array(
                        'key' => '_thumbnail_id'
                      )
                    ),
                    'orderby'                 => 'rand',
                    'no_found_rows'           => true,
                    'update_post_meta_cache'  => false
                  ) );

                  if( $query->have_posts() ):
                    while( $query->have_posts() ):
                      $query->the_post();

                      $exclude[] = get_the_id();
                      get_template_part( 'template-parts/reference', 'mosaic-upsell' );
                    endwhile;
                  endif; wp_reset_postdata();

                  $query = new WP_Query( array(
                    'post_type'               => 'reference',
                    'post_status'             => 'publish',
                    'posts_per_page'          => 2,
                    'meta_key'                => '_thumbnail_id',
                    'post__not_in'            => $exclude,
                    'no_found_rows'           => true,
                    'update_post_meta_cache'  => false
                  ) );

                  if( $query->have_posts() ):
                    while( $query->have_posts() ):
                      $query->the_post();

                      $exclude[] = get_the_id();
                      get_template_part( 'template-parts/reference', 'mosaic-secondary' );
                      endwhile;
                  endif; wp_reset_postdata(); ?>

                </div>

                <div class="mosaic-section">

                  <?php $query = new WP_Query( array(
                    'post_type'               => 'reference',
                    'post_status'             => 'publish',
                    'posts_per_page'          => 2,
                    'meta_key'                => '_thumbnail_id',
                    'post__not_in'            => $exclude,
                    'no_found_rows'           => true,
                    'update_post_meta_cache'  => false
                  ) );

                  if( $query->have_posts() ):
                    $i = 1; $y = 1;

                    while( $query->have_posts() ):
                      $query->the_post();
                      include( locate_template( 'template-parts/reference-mosaic-secondary-variable.php' ) );
                    endwhile;
                  endif; wp_reset_postdata(); ?>

                </div><!-- .mosaic-section -->

              </div><!-- .cols -->

            </div><!-- .container -->
          <?php endif;

          if( !empty( $clients_title ) ): ?>
            <div class="container clients">
              <h2><?php echo $clients_title ?></h2>

              <div class="logos">

                <div class="row row-first">

                  <div class="col logo-bauermedia">
                    <?php echo file_get_contents( get_theme_file_path( 'svg/logo-bauermedia.svg' ) ); ?>
                  </div>

                  <div class="col logo-elonen">
                    <?php echo file_get_contents( get_theme_file_path( 'svg/logo-elonen.svg' ) ); ?>
                  </div>

                  <div class="col logo-sohwi">
                    <?php echo file_get_contents( get_theme_file_path( 'svg/logo-sohwi-original.svg' ) ); ?>
                  </div>

                  <div class="col logo-jyvaskyla">
                    <?php echo file_get_contents( get_theme_file_path( 'svg/logo-jyvaskyla.svg' ) ); ?>
                  </div>

                  <div class="col logo-paytrail">
                    <?php echo file_get_contents( get_theme_file_path( 'svg/logo-paytrail.svg' ) ); ?>
                  </div>

                </div><!-- .row -->

                <div class="row row-second">

                  <div class="col">
                    <?php echo file_get_contents( get_theme_file_path( 'svg/logo-papu.svg' ) ); ?>
                  </div>

                  <div class="col">
                    <?php echo file_get_contents( get_theme_file_path( 'svg/logo-hotellialba.svg' ) ); ?>
                  </div>

                  <div class="col">
                    <?php echo file_get_contents( get_theme_file_path( 'svg/logo-realsnacks.svg' ) ); ?>
                  </div>

                  <div class="col col-harmooni">
                    <?php echo file_get_contents( get_theme_file_path( 'svg/logo-harmooni.svg' ) ); ?>
                  </div>

                </div><!-- .row -->

              </div><!-- .logos -->
            </div>
          <?php endif; ?>

        </div><!-- .block-feed -->
      <?php endif; ?>

      <?php if( !empty( $blog_title ) ) :
        get_template_part( 'template-parts/blog-scroller' );
      endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
