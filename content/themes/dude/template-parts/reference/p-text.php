<?php if( !empty( $part['content'] ) ): ?>
  <div class="slide slide-customer-story">

    <div class="container">

      <div class="general-description">
        <?php if( !empty( $part['sub_title'] ) ): ?>
          <h2><span class="order-number"><?php printf( '%02d', $text_area_numbering ); ?></span> <?php echo $part['sub_title'] ?></h2>
        <?php $text_area_numbering++; endif;

        echo wpautop( $part['content'] ); ?>
      </div><!-- .general-description -->

    </div><!-- .container -->

  </div><!-- .slide -->
<?php endif; ?>
