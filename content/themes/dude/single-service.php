<?php the_post();
$post_id = get_the_id();

// Get area 1 content
$area_01_title = get_post_meta( $post_id, '_area_01_title', true );
$advantages = carbon_get_post_meta( $post_id, '_advantages', 'complex' );

// Get blog area content
$blog_title = get_post_meta( $post_id, '_blog_title', true );
$blog_cat = get_post_meta( $post_id, '_blog_category', true );

// Get references area content
$references_title = get_post_meta( $post_id, '_references_title', true );
$references_service = get_post_meta( get_the_id(), '_references_service', true );

// Get quote area content
$quote_area_title = get_post_meta( $post_id, '_quote_title', true );
$quote_service = get_post_meta( $post_id, '_quote_service', true );
if( !empty( $quote_service ) ) {
  $quote_query = new WP_Query( array(
    'post_type'               => 'reference',
    'post_status'             => 'publish',
    'posts_per_page'          => 1,
    'tax_query'               => array(
      array(
        'taxonomy'  => 'service',
        'terms'     => $quote_service
      )
    ),
    'meta_query'              => array(
      array(
        'key'       => '_quote'
      ),
      array(
        'key'       => '_quote_name'
      ),
      array(
        'key'       => '_quote_title'
      ),
      array(
        'key'       => '_quote_image'
      )
    ),
    'orderby'                 => 'rand',
    'no_found_rows'           => true
  ) );

  if( $quote_query->have_posts() ) {
    while( $quote_query->have_posts() ) {
      $quote_query->the_post();
      $quote_post_id = get_the_id();
      $quote_company = get_the_title();
    }
  } wp_reset_postdata();

  $quote = get_post_meta( $quote_post_id, '_quote', true );
  $quote_name = get_post_meta( $quote_post_id, '_quote_name', true );
  $quote_title = get_post_meta( $quote_post_id, '_quote_title', true );
  $quote_image = get_post_meta( $quote_post_id, '_quote_image', true );
}

// Get area 2 content
$area_02_title = get_post_meta( $post_id, '_area_02_title', true );
$area_02_content = get_post_meta( $post_id, '_area_02_content', true );
$area_02_list_title = get_post_meta( $post_id, '_area_02_list_title', true );
$area_02_list = carbon_get_post_meta( $post_id, '_area_02_list', 'complex' );
$area_02_price = get_post_meta( $post_id, '_area_02_price', true );
$area_02_price_desc = get_post_meta( $post_id, '_area_02_price_desc', true );
$area_02_cta_text = get_post_meta( $post_id, '_area_02_cta_text', true );
$area_02_cta_url = get_post_meta( $post_id, '_area_02_cta_url', true );

// Start outputting the content
get_header();
get_template_part( 'template-parts/hero', 'service' ); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

      <div class="slide slide-service-info">

        <div class="container">

          <div class="service-description">
            <?php if( !empty( $area_01_title ) ): ?>
              <h2><span class="order-number">01</span> <?php echo $area_01_title ?></h2>
            <?php endif; ?>
            <?php the_content(); ?>
          </div><!-- .service-description -->

          <?php if( !empty( $advantages ) ): ?>
            <div class="steps steps-<?php echo get_post_field( 'post_name' ) ?>">
              <ol>
                <?php foreach( $advantages as $advantage ):
                  if( !empty( $advantage['title'] ) && !empty( $advantage['content'] ) ): ?>
                    <li>
                      <h4><?php echo $advantage['title']; ?></h4>

                      <p><?php echo $advantage['content']; ?></p>
                    </li>
                  <?php endif;
                endforeach; ?>
              </ol>
            </div><!-- .steps -->
          <?php endif; ?>

        </div><!-- .container -->

      </div><!-- .slide -->

      <?php if( !empty( $references_title ) && !empty( $references_service ) ): ?>
        <div class="slide slide-service-references slide-<?php echo get_post_field( 'post_name' ) ?>">

          <div class="container">

            <h2><?php echo $references_title ?></h2>

            <div class="cols cols-references">

              <div class="mosaic-section">

                <?php $query = new WP_Query( array(
                  'post_type'               => 'reference',
                  'post_status'             => 'publish',
                  'posts_per_page'          => 4,
                  'meta_key'                => '_thumbnail_id',
                  'tax_query'               => array(
                    array(
                      'taxonomy' => 'service',
                      'terms'    => array( $references_service )
                    )
                  ),
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

          <?php if( !empty( $quote_area_title ) && isset( $quote_post_id ) ): ?>
            <div class="container container-service-quote">

              <h2><?php echo $quote_area_title ?></h2>

              <div class="general-description">
                <blockquote>
                  <?php echo wpautop( $quote ) ?>
                </blockquote>

                <div class="customer">
                  <div class="avatar" style="background-image: url('<?php echo wp_get_attachment_image_src( $quote_image, 'large' )[0] ?>');"></div>
                  <h4><?php echo $quote_name ?></h4>
                  <h6><?php echo $quote_title ?>, <?php echo $quote_company ?></h6>
                </div><!-- .customer -->

              </div><!-- .general-description -->

            </div><!-- .container -->
          <?php endif; ?>

        </div><!-- .slide -->
      <?php endif;

      if( !empty( $blog_title ) && !empty( $blog_cat ) ) {
        get_template_part( 'template-parts/blog-scroller' );
      }

      if( !empty( $area_02_title ) && !empty( $area_02_content ) ): ?>
        <div class="slide slide-hosting-info">

          <div class="container">
            <div class="service-description">
              <h2><span class="order-number">02</span> <?php echo $area_02_title ?></h2>
              <?php echo wpautop( $area_02_content ); ?>
            </div><!-- .service-description -->

            <?php if( !empty( $area_02_list_title ) && !empty( $area_02_list ) ): ?>
              <div class="hosting">

                <h3><?php echo $area_02_list_title ?></h3>

                <ul>
                  <?php foreach( $area_02_list as $item ):
                    if( !empty( $item['item'] ) ): ?>
                      <li><span><?php echo $item['item'] ?></span></li>
                    <?php endif;
                  endforeach; ?>
                </ul>

                <?php if( !empty( $area_02_price ) && !empty( $area_02_price_desc ) ): ?>
                  <div class="pricing">
                    <p><?php _e( 'Alk', 'dude' ) ?> <span class="price"><?php echo $area_02_price ?>&euro;</span> / <span class="month"><?php _e( 'kk', 'dude' ) ?></span>
                    <span class="pricing-label"><?php echo $area_02_price_desc ?></span></p>
                  </div>
                <?php endif;

                if( !empty( $area_02_cta_url ) && !empty( $area_02_cta_text ) ): ?>
                  <p><a class="button" href="<?php echo $area_02_cta_url ?>"><?php echo $area_02_cta_text ?></a></p>
                <?php endif; ?>

              </div><!-- .hosting -->
            <?php endif; ?>
          </div><!-- .container -->

        </div><!-- .slide -->
      <?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
