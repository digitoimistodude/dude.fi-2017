<?php
/**
 * Service hero template file.
 *
 * This is the default hero image for page templates, called
 * 'slide'. Strictly dude specific.
 *
 * @package dude
 */

$hero_desc = get_post_meta( get_the_id(), '_hero_desc', true ); ?>

<div class="slide slide-hero slide-<?php echo get_post_field( 'post_name' ) ?>" <?php if ( has_post_thumbnail() ) : ?> style="background-image:url('<?php echo esc_url(wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>');"<?php endif; ?>>
  <div class="shade"></div>
  <div class="shade shade-extra"></div>

  <div class="container">

    <h1><?php echo get_the_title(); ?></h1>

    <?php if( !empty( $hero_desc ) ) {
      echo wpautop( $hero_desc );
    } ?>

  </div><!-- .container -->
</div>
