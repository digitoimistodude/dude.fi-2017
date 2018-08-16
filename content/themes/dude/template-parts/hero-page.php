<?php
/**
 * Default hero template file.
 *
 * This is the default hero image for page templates, called
 * 'block'. Strictly dude specific.
 *
 * @package dude
 */

?>

<div class="block block-hero" <?php if ( has_post_thumbnail() ) : ?> style="background-image:url('<?php echo esc_url(wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>');"<?php endif; ?>>
  <div class="shade"></div>

  <div class="block-inner--centered">
    <div class="container">

      <?php the_title( '<h1>', '</h1>' ); ?>

    </div>
  </div>
</div>
