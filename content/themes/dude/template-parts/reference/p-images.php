<?php if( !empty( $part['images'] ) ):

  if( count( $part['images'] ) <= 2 ):
    $slide_classes = 'slide-images-with-padding';
    $image_wrapper_classes = 'images';

    if( $part['lift_up'] ) {
      $slide_classes = 'slide-reference-images slide-no-bottom-padding';
      $image_wrapper_classes = 'image-columns';
    } ?>

    <div class="slide <?php echo $slide_classes ?>">
      <div class="container">
        <div class="<?php echo $image_wrapper_classes ?>">
          <?php foreach( $part['images'] as $image ): ?>
            <div class="image" style="background-image: url('<?php echo wp_get_attachment_image_src( $image['image'], 'full' )[0] ?>');"></div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="slide slide-three-showcase">
      <div class="container">
        <?php foreach( $part['images'] as $image ): ?>
          <div class="col" style="background-image: url('<?php echo wp_get_attachment_image_src( $image['image'], 'full' )[0] ?>');"></div>
        <?php endforeach; ?>
      </div><!-- .container -->
    </div>
  <?php endif; ?>
<?php endif; ?>
