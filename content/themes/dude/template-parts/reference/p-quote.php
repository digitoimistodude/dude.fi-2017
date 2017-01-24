<?php

$quote = get_post_meta( get_the_id(), '_quote', true );
$quote_name = get_post_meta( get_the_id(), '_quote_name', true );
$quote_title = get_post_meta( get_the_id(), '_quote_title', true );
$quote_image = get_post_meta( get_the_id(), '_quote_image', true ); ?>

<div class="slide slide-customer-story <?php if( empty( $part['sub_title'] ) ): ?>no-top-padding<?php endif; ?>">

  <div class="container">

    <div class="general-description">
      <?php if( !empty( $part['sub_title'] ) ): ?>
        <h2><span class="order-number"><?php printf( '%02d', $text_area_numbering ); ?></span> <?php echo $part['sub_title'] ?></h2>
      <?php $text_area_numbering++; endif; ?>

      <blockquote>
        <?php echo wpautop( $quote ) ?>
      </blockquote>

      <div class="customer">
        <div class="avatar" style="background-image: url('<?php echo wp_get_attachment_image_src( $quote_image, 'large' )[0] ?>');"></div>
        <h4><?php echo $quote_name ?></h4>
        <h6><?php echo $quote_title ?></h6>
      </div><!-- .customer -->

    </div><!-- .general-description -->

  </div><!-- .container -->

</div><!-- .slide -->
