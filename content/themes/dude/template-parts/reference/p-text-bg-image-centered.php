<?php if( !empty( $part['image'] ) && !empty( $part['content'] ) ):
  if( !empty( $part['content_color'] ) ): ?>
    <style>
      .slide-customer-story .container span,
      .slide-customer-story .container h2,
      .slide-customer-story .container p {
        color: <?php echo $part['content_color'] ?> !important;
      }

      .slide-customer-story .container span:after {
        background: <?php echo $part['content_color'] ?> !important;
      }
    </style>
  <?php endif; ?>

  <div class="slide slide-customer-story slide-dark-with-images" style="background-image: url('<?php echo wp_get_attachment_image_src( $part['image'], 'full' )[0] ?>');">

    <div class="container">

      <div class="general-description">
        <?php if( !empty( $part['sub_title'] ) ): ?>
          <h2><span class="order-number"><?php printf( '%02d', $text_area_numbering ); ?></span> <?php echo $part['sub_title']; ?></h2>
        <?php $text_area_numbering++; endif;

        echo wpautop( $part['content'] ); ?>
      </div><!-- .general-description -->

    </div><!-- .container -->

  </div><!-- .slide -->
<?php endif; ?>
