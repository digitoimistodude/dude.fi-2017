<?php the_post();

// Upsell area content
$project_upsell = get_post_meta( get_the_id(), '_project_upsell', true );
$linked_user = get_post_meta( get_the_id(), '_linked_user', true );
$handle_instagram = get_post_meta( get_the_id(), '_handle_instagram', true );

$user_posts = false;
if( !empty( $linked_user ) ) {
  $user_posts = new WP_Query( array(
    'author'                  => $linked_user,
    'post_type'               => 'post',
    'post_status'             => 'publish',
    'posts_per_page'          => 1,
    'no_found_rows'           => true,
    'update_post_meta_cache'  => false,
    'update_post_term_cache'  => false
  ) );
}

$instagram = false;
if( !empty( $handle_instagram ) ) {
  $instagram = dude_insta_feed()->get_user_images( $handle_instagram );
}

// Two columns area content
$cols_title = get_post_meta( get_the_id(), '_2col_title', true );
$cols_1 = get_post_meta( get_the_id(), '_col1', true );
$cols_2 = get_post_meta( get_the_id(), '_col2', true );
$img_1 = get_post_meta( get_the_id(), '_image1', true );
$img_2 = get_post_meta( get_the_id(), '_image2', true );

// Numbers area content
$numbers_title = get_post_meta( get_the_id(), '_numbers_title', true );
$numbers_bg = get_post_meta( get_the_id(), '_numbers_image', true );
$numbers = carbon_get_post_meta( get_the_id(), '_numbers', 'complex' );

// Persons area content
$persons_title = __( 'Tsekkaa muut dudexet', 'dude' );
$persons_query = new WP_Query( array(
  'post_type'             => 'person',
  'post_status'           => 'publish',
  'posts_per_page'        => 3,
  'order'						      => 'ASC',
  'orderby'					      => 'menu_order title',
  'post__not_in'          => array( get_the_id() ),
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

// Start outputting the page
get_header();
get_template_part( 'template-parts/hero', 'person' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

      <div class="slide slide-person-introduction">

        <div class="container">
          <?php the_content(); ?>
        </div><!-- .container -->

      </div><!-- .slide -->


      <?php if( !empty( $project_upsell ) && !empty( $instagram['data'][0] ) && $user_posts ): ?>
        <div class="slide slide-person-top-things">

          <div class="container">

            <div class="col">
              <div class="slot" style="background-image: url('<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id( $project_upsell ) ) ); ?>')">
                <div class="shade"></div>
                <div class="shade shade-extra"></div>
                <a href="<?php echo get_the_permalink( $project_upsell ) ?>"></a>

                <h3><?php echo get_the_title( $project_upsell ); ?></h3>
              </div>

              <h3><?php _e( 'Mieluisin projekti', 'dude' ) ?></h3>
            </div>

            <?php while( $user_posts->have_posts() ):
              $user_posts->the_post(); ?>
              <div class="col">
                <div class="slot" style="background-image: url('<?php echo the_post_thumbnail_url( 'large' ) ?>')">
                  <div class="shade"></div>
                  <div class="shade shade-extra"></div>
                  <a href="<?php the_permalink() ?>"></a>

                  <h3><?php the_title() ?></h3>
                </div>

                <h3><?php _e( 'Uusin kirjoitus', 'dude' ) ?></h3>
              </div>
            <?php endwhile; wp_reset_postdata(); ?>

            <div class="col">
              <div class="slot" style="background-image: url('<?php echo $instagram['data'][0]['images']['standard_resolution']['url'] ?>')">
                <div class="shade"></div>
                <div class="shade shade-extra"></div>
                <a href="<?php echo $instagram['data'][0]['link'] ?>" target="_blank"></a>

                <h3>
                  <?php echo file_get_contents( get_theme_file_path('svg/heart.svg') );
                  if( $instagram['data'][0]['likes']['count'] < 1 ) {
                    _e( 'tykkää', 'dude' );
                  } else {
                    printf( esc_html( _n( '%d tykkäys', '%d tykkäystä', $instagram['data'][0]['likes']['count'], 'dude'  ) ), $instagram['data'][0]['likes']['count'] );
                  } ?>
                </h3>
              </div>

              <h3><?php _e( 'Instagram', 'dude' ) ?></h3>
            </div>

          </div><!-- .container -->

        </div><!-- .slide -->
      <?php endif; ?>

      <?php if( !empty( $cols_title ) ): ?>
        <div class="slide slide-person-more">

          <div class="container">

            <h2><?php echo $cols_title ?></h2>

            <?php if( !empty( $cols_1 ) && !empty( $cols_2 ) ): ?>
              <div class="cols">

                <div class="col"><?php echo wpautop( $cols_1 ) ?></div>

                <div class="col"><?php echo wpautop( $cols_2 ) ?></div>

              </div><!-- .cols -->
            <?php endif;

            if( !empty( $img_1 ) && !empty( $img_2 ) ): ?>
              <div class="cols cols-images">

                <div class="col col-image" style="background-image: url('<?php echo esc_url( wp_get_attachment_url( $img_1 ) ); ?>');";></div>
                <div class="col col-image" style="background-image: url('<?php echo esc_url( wp_get_attachment_url( $img_2 ) ); ?>');";></div>

              </div>
            <?php endif; ?>

          </div><!-- .container -->

        </div><!-- .slide -->
      <?php endif;

      if( !empty( $numbers_title ) && !empty( $numbers_bg ) && !empty( $numbers ) ): ?>
        <div class="slide slide-stats" style="background-image: url('<?php echo esc_url( wp_get_attachment_url( $numbers_bg ) ); ?>');";>
          <div class="shade"></div>

          <div class="container">

            <h2><?php echo $numbers_title ?></h2>

            <div class="numbers">
              <?php foreach( $numbers as $number ):
                if( $number['type'] === 'dynamic' ):
                  include( locate_template( 'template-parts/person-number/'.$number['dynamic'].'.php' ) );
                else: ?>
                  <div class="number">
                    <span class="value"><?php echo $number['value'] ?></span>
                    <span class="label"><?php echo $number['label'] ?></span>
                    <?php if( !empty( $number['below_label'] ) ): ?>
                      <span class="time"><?php echo $number['below_label'] ?></span>
                      </span>
                    <?php endif; ?>
                  </div>
                <?php endif;
              endforeach; ?>
            </div>

            <?php //require get_template_directory().'/inc/todoist.php'; ?>

          </div><!-- .container -->

        </div><!-- .slide -->
      <?php endif;

      set_query_var( 'persons_title', $persons_title );
      set_query_var( 'persons_query', $persons_query );
      get_template_part( 'template-parts/staff', 'slider' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
