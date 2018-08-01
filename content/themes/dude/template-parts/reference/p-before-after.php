<?php if( !empty( $part['bg_color'] ) && !empty( $part['image1'] ) && !empty( $part['image2'] ) ): ?>

  <div class="block block-before-after" style="background-color: <?php echo $part['bg_color'] ?>;">
    <div class="shade"></div>

    <div class="container">

      <div class="image-wrapper before">

        <?php if( !empty( $part['label1'] ) ): ?>
          <h3><?php echo $part['label1'] ?></h3>
        <?php endif; ?>

        <div class="image-frame" style="background-image: url('<?php echo wp_get_attachment_image_src( $part['image1'], 'full' )[0] ?>');"></div>

      </div><!-- .image-wrapper -->

      <div class="image-wrapper after">

        <?php if( !empty( $part['label2'] ) ): ?>
          <h3><?php echo $part['label2'] ?></h3>
        <?php endif; ?>

        <div class="image-frame" style="background-image: url('<?php echo wp_get_attachment_image_src( $part['image2'], 'full' )[0] ?>');"></div>

      </div><!-- .image-wrapper -->

    </div><!-- .container -->

  </div><!-- .block -->
<?php endif; ?>
