<?php if( !empty( $part['image'] ) && !empty( $part['content'] ) ):
  if( !empty( $part['content_color'] ) ): ?>

    <style>
      .block-reference-description .container span,
      .block-reference-description .container h2,
      .block-reference-description .container p {
        color: <?php echo $part['content_color'] ?> !important;
      }

      .block-reference-description .container span:after {
        background: <?php echo $part['content_color'] ?> !important;
      }
    </style>
  <?php endif; ?>

  <div class="block block-reference-description" style="background-image: url('<?php echo wp_get_attachment_image_src( $part['image'], 'full' )[0] ?>');">

    <div class="container numbered">

      <div class="col">
        <?php if( !empty( $part['sub_title'] ) ): ?>
          <h2><span class="order-number"><?php printf( '%02d', $text_area_numbering ); ?></span> <?php echo $part['sub_title']; ?></h2>
        <?php $text_area_numbering++; endif;

        echo wpautop( $part['content'] ); ?>
      </div><!-- .col -->

    </div><!-- .container -->

  </div><!-- .block -->
<?php endif; ?>
