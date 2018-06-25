<?php if( !empty( $part['image'] ) ):

  if( !empty( $part['wide_img'] ) ): ?>
    <div class="block block-reference-image">
      <?php echo wp_get_attachment_image( $part['image'], 'full', '', array( 'class' => 'reference-image' ) ); ?>
    </div>
  <?php else: ?>
    <div class="block block-single-centered-image">
      <div class="container">
        <?php echo wp_get_attachment_image( $part['image'], 'full' ) ?>
      </div>
    </div><!-- .block -->
  <?php endif;
endif; ?>
