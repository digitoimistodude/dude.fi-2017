<?php if( !empty( $persons_title ) && $persons_query->have_posts() ): ?>
  <div class="slide slide-staff<?php if( is_singular( 'person' ) ): echo ' slide-staff-single-person'; endif; ?>">

    <div class="container <?php if( is_singular( 'person' ) ): echo ' dudet-3'; endif; ?>">

      <h2><?php echo $persons_title ?></h2>

      <div class="staff">
        <div class="wrap-preventer">
          <?php while( $persons_query->have_posts() ):
            $persons_query->the_post();
            $image_id = get_post_meta( get_the_id(), '_quote_image', true );
            $quote = get_post_meta( get_the_id(), '_quote', true );
            $job_title = get_post_meta( get_the_id(), '_job_title', true ); ?>

            <div class="col" style="background-image:url('<?php echo wp_get_attachment_url( $image_id ) ?>')">
              <a href="<?php the_permalink() ?>" class="permalink"></a>
              <div class="shade"></div>
              <div class="content">
                <blockquote><?php echo wpautop( $quote ) ?></blockquote>
                <cite>
                  <h3><?php the_title() ?></h3>
                  <?php if( !empty( $job_title ) ): echo $job_title; endif; ?>
                </cite>
              </div>
            </div><!-- .col -->
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
    </div><!-- .container -->

  </div><!-- .slide-staff -->
<?php endif; ?>
