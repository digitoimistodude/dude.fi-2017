<?php the_post();
/**
 * Template Name: Dude
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package dude
 */

// Hero content
$hero_title = get_post_meta( get_the_id(), '_hero_title', true );
$hero_desc = get_post_meta( get_the_id(), '_hero_desc', true );
if( empty( $hero_title ) ) {
  $hero_title = get_the_title();
}

// Content area content
$number_1_value = get_post_meta( get_the_id(), '_number_1_value', true );
$number_1_label = get_post_meta( get_the_id(), '_number_1_label', true );
$number_2_value = get_post_meta( get_the_id(), '_number_2_value', true );
$number_2_label = get_post_meta( get_the_id(), '_number_2_label', true );
$number_3_value = get_post_meta( get_the_id(), '_number_3_value', true );
$number_3_label = get_post_meta( get_the_id(), '_number_3_label', true );
$number_4_value = get_post_meta( get_the_id(), '_number_4_value', true );
$number_4_label = get_post_meta( get_the_id(), '_number_4_label', true );

// Persons area content
$persons_title = get_post_meta( get_the_id(), '_persons_title', true );
$persons_query = new WP_Query( array(
  'post_type'             => 'person',
  'post_status'           => 'publish',
  'posts_per_page'        => 4,
  'order'						      => 'ASC',
  'orderby'					      => 'menu_order title',
  'meta_query'            => array(
    array(
      'key'      => '_quote',
    ),
    array(
      'key'      => '_quote_image',
    )
  ),
  'no_found_rows'           => true,
  'update_post_term_cache'  => false
) );

// Values area content
$values_title = get_post_meta( get_the_id(), '_values_title', true );
$values = carbon_get_post_meta( get_the_id(), '_values', 'complex' );

// Start outputting the page
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

      <div class="slide slide-first slide-dude"<?php if( has_post_thumbnail() ) : ?> style="background-image:url('<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>');"<?php endif; ?>>
        <div class="shade"></div>
        <div class="shade shade-extra"></div>

        <div class="container container-centered">

          <h1><?php echo $hero_title ?></h1>

          <?php if( !empty( $hero_desc ) ): ?>
            <p><?php echo $hero_desc ?></p>
          <?php endif; ?>

        </div><!-- .container -->

      </div><!-- .slide -->

      <div class="slide slide-dude-content">

        <div class="container">

          <div class="cols">

            <div class="col">
              <?php the_content() ?>
            </div><!-- .col -->

            <div class="col numbers">
              <?php if( !empty( $number_1_value ) && !empty( $number_1_label ) ) : ?>
                <div class="number">
                  <span class="value"><?php echo $number_1_value ?></span>
                  <span class="label"><?php echo $number_1_label ?></span>
                </div>
              <?php endif; ?>

              <?php if( !empty( $number_2_value ) && !empty( $number_2_label ) ) : ?>
                <div class="number">
                  <span class="value"><?php echo $number_2_value ?></span>
                  <span class="label"><?php echo $number_2_label ?></span>
                </div>
              <?php endif; ?>

              <?php if( !empty( $number_3_value ) && !empty( $number_3_label ) ) : ?>
                <div class="number">
                  <span class="value"><?php echo $number_3_value ?></span>
                  <span class="label"><?php echo $number_3_label ?></span>
                </div>
              <?php endif; ?>

              <?php if( !empty( $number_4_value ) && !empty( $number_4_label ) ) : ?>
                <div class="number">
                  <span class="value"><?php echo $number_4_value ?></span>
                  <span class="label"><?php echo $number_4_label ?></span>
                </div>
              <?php endif; ?>
            </div><!-- .col -->

          </div><!-- .cols -->

        </div><!-- .container -->
      </div><!-- .slide -->

      <?php set_query_var( 'persons_title', $persons_title );
      set_query_var( 'persons_query', $persons_query );
      get_template_part( 'template-parts/staff', 'slider' );

      if( !empty( $values_title ) && !empty( $values ) ): ?>
        <div class="slide slide-values">

          <div class="container">

            <div class="dude-values">

              <div class="column-title">
                <h2><?php echo $values_title ?></h2>
              </div>

              <div class="column-values">

                <div class="dude-columns">

                  <?php foreach( $values as $value ):
                    if( empty( $value['title'] ) && !empty( $value['content'] ) )
                      continue; ?>

                    <div class="column">
                      <h3><?php echo file_get_contents( get_theme_file_path( 'svg/neckbeard.svg' ) ); ?><?php echo $value['title'] ?></h4>

                      <p><?php echo $value['content'] ?></p>
                    </div><!-- .column -->
                  <?php endforeach; ?>

                </div><!-- .dude-columns -->

              </div>

            </div><!-- .dude-values -->

          </div>

        </div><!-- .slide -->
      <?php endif; ?>

      <?php get_template_part( 'template-parts/blog-scroller' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
