<?php if( !empty( $part['content'] ) && !empty( $part['image'] ) ): ?>
  <div class="slide slide-customer-story slide-customer-story-columns">

    <div class="container">

      <div class="general-description">

        <div class="column column-text">

          <?php if( !empty( $part['sub_title'] ) ): ?>
            <h2><span class="order-number"><?php printf( '%02d', $text_area_numbering ); ?></span> <?php echo $part['sub_title'] ?></h2>
          <?php $text_area_numbering++; endif;

          echo wpautop( $part['content'] ) ?>

        </div><!-- .column-text -->

        <div class="column column-image">
          <?php echo wp_get_attachment_image( $part['image'], 'full' ) ?>
        </div><!-- .column-image -->

      </div><!-- .general-description -->

    </div><!-- .container -->

  </div><!-- .slide -->
<?php endif; ?>
