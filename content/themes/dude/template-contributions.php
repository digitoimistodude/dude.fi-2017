<?php the_post();
/**
 * Template Name: Contributions
 */

// Hero content
$hero_desc = get_post_meta( get_the_id(), '_hero_desc', true );

// Tech content
$techniques_title = get_post_meta( get_the_id(), '_techniques_title', true );

// Contributions content
$contributions_title = get_post_meta( get_the_id(), '_contributions_title', true );

// Start outputting the page
get_header(); ?>

<div id="particles-js"></div>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

    <div class="block block-hero block-hero-contributions"<?php if( has_post_thumbnail() ): ?>  style="background-image:url('<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>');"<?php endif; ?>>
      <div class="shade"></div>

      <div class="container">
				<h1 class="page-title"><?php the_title(); ?></h1>

        <?php if( !empty( $hero_desc ) ): ?>
          <p><?php echo $hero_desc ?></p>
        <?php endif; ?>

        <p><a href="#kontribuutiot" class="button button-white"><?php _e( 'Katso julkaisumme', 'dude' ) ?></a></p>

      </div>
    </div><!-- .block -->

    <div class="block block-contributions-introduction">

      <div class="container">
        <?php the_content(); ?>
      </div><!-- .container -->

    </div><!-- .block -->

    <?php if( !empty( $techniques_title ) ): ?>
      <div class="block block-techniques">

        <div class="container">
          <h2><?php echo $techniques_title ?></h2>

          <div class="tech-logo-wrapper">

            <div class="logos-tech">

              <div class="row row-first">

                <div class="col col-sass">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-sass.svg' ) ); ?>
                </div>

                <div class="col col-capistrano">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-capistrano.svg' ) ); ?>
                </div>

                <div class="col col-html">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-html.svg' ) ); ?>
                </div>

                <div class="col col-gulp">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-gulp.svg' ) ); ?>
                </div>

                <div class="col col-npm">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-npm.svg' ) ); ?>
                </div>

              </div><!-- .row -->

              <div class="row row-second">

                <div class="col col-jquery">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-jquery.svg' ) ); ?>
                </div>

                <div class="col col-javascript">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-javascript.svg' ) ); ?>
                </div>

                <div class="col col-git">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-git.svg' ) ); ?>
                </div>

                <div class="col col-nginx">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-nginx.svg' ) ); ?>
                </div>

              </div><!-- .row -->

              <div class="row row-second">

                <div class="col col-vue">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-vue.svg' ) ); ?>
                </div>

                <div class="col col-svg">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-svg.svg' ) ); ?>
                </div>

                <div class="col col-composer">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-composer.svg' ) ); ?>
                </div>

                <div class="col col-php">
                  <?php echo file_get_contents( get_theme_file_path( 'svg/logo-php.svg' ) ); ?>
                </div>

              </div><!-- .row -->

            </div><!-- .logos -->
          </div>
        </div>
      </div><!-- .block -->
    <?php endif;

    if( !empty( $contributions_title ) ): ?>
      <div class="block block-contributions" id="kontribuutiot">

        <div class="container">
          <h2><?php echo $contributions_title ?></h2>

          <?php $query = new WP_Query( array(
            'post_type'				=> 'contribution',
            'post_status'			=> 'publish',
            'posts_per_page'	=> 50,
            'order'						=> 'ASC',
            'orderby'					=> 'menu_order title',
            'meta_key'        => '_contribution_type',
            'no_found_rows'		=> true,
          ) );

          if( $query->have_posts() ): ?>
            <div class="wrapper">
              <?php while( $query->have_posts() ):
                $query->the_post();
                get_template_part( 'template-parts/single', 'contribution' );
              endwhile; ?>
            </div>
          <?php endif; wp_reset_postdata(); ?>
        </div>
      </div>
    <?php endif; ?>

	</main>
</div>

<script>
	particlesJS.load( 'particles-js', '<?php echo get_theme_file_uri( 'js/src/particles.json' ) ?>' );
</script>

<?php get_footer();
