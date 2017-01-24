<?php $image_id = get_post_thumbnail_id();
$image = wp_get_attachment_url( $image_id );
$services = wp_get_post_terms( get_the_id(), 'service', array( 'fields' => 'id=>name' ) );

if( $i % 2 != 0 ) {
  if( $y % 2 != 0 ) {
    $class = 'mosaic-narrow';
  } else {
    $class = 'mosaic-wide';
  }
} else {
  if( $y % 2 != 0 ) {
    $class = 'mosaic-wide';
  } else {
    $class = 'mosaic-narrow';
  }

  $y++;
}

$i++; ?>
<div class="mosaic mosaic-secondary <?php echo $class ?>" style="background-image: url('<?php echo $image ?>');">
  <div class="shade"></div>

  <a class="permalink" href="<?php the_permalink() ?>"></a>
  <div class="reference-meta">
    <h3><?php the_title() ?></h3>
    <?php if( !is_wp_error( $services ) && !empty( $services ) ):
      $services_count = count( $services );
      $x = 1; ?>
      <p>
        <?php foreach( $services as $service_id => $service ):
          $service_page_id = get_term_meta( $service_id, '_service_page_id', true );

          if( !empty( $service_page_id ) && is_string( get_post_status( $service_page_id ) ) )
            echo '<a href="'.get_permalink( $service_page_id ).'">';

          echo $service;

          if( !empty( $service_page_id ) && is_string( get_post_status( $service_page_id ) ) )
            echo '</a>';

          if( $x < $services_count )
            echo ' & ';
        $x++; endforeach; ?>
      </p>
    <?php endif; ?>
  </div>
</div>
