<?php $image_id = get_post_thumbnail_id();
$image = wp_get_attachment_url( $image_id );
$services = wp_get_post_terms( get_the_id(), 'service', array( 'fields' => 'id=>name' ) ); ?>
<div class="mosaic mosaic-secondary" style="background-image: url('<?php echo $image ?>');">
  <div class="shade"></div>
  <a href="<?php the_permalink() ?>" class="permalink" aria-label="<?php echo esc_html_e('Linkki kohteeseen ', 'dude'); the_title(); ?>"></a>
  <div class="reference-meta">
    <h2 class="reference-meta-title"><?php the_title(); ?></h2>
    <?php if( !is_wp_error( $services ) && !empty( $services ) ):
      $services_count = count( $services );
      $i = 1; ?>
      <p>
        <?php foreach( $services as $service_id => $service ):
          $service_page_id = get_term_meta( $service_id, '_service_page_id', true );

          if( !empty( $service_page_id ) && is_string( get_post_status( $service_page_id ) ) )
            echo '<a href="'.get_permalink( $service_page_id ).'">';

          echo $service;

          if( !empty( $service_page_id ) && is_string( get_post_status( $service_page_id ) ) )
            echo '</a>';

          if( $i < $services_count )
            echo ' & ';
        $i++; endforeach; ?>
      </p>
    <?php endif; ?>
  </div>
</div>
