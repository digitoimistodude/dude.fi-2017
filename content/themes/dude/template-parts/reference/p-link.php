<?php if( !empty( $site_url ) ): ?>
  <div class="slide slide-visit-site">

    <div class="container no-top-padding">

      <div class="general-description">
        <p class="button-wrapper">
          <a href="<?php echo $site_url ?>" class="button button-with-arrow" target="_blank"><span><?php _e( 'Vieraile sivustolla', 'dude' ); ?></span><?php echo file_get_contents( get_theme_file_path( 'svg/large-cta-arrow.svg' ) ); ?></a>
        </p>
      </div><!-- .general-description -->

    </div><!-- .container -->

  </div><!-- .slide -->
<?php endif; ?>
