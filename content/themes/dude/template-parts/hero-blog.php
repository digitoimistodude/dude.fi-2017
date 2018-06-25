<?php
/**
 * Blog hero template file.
 *
 * This is the default hero image for page templates, called
 * 'block'. Strictly dude specific.
 *
 * @package dude
 */

?>

<div class="block block-hero block-hero-single-blog" <?php if ( has_post_thumbnail() ) : ?> style="background-image:url('<?php echo esc_url(wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>');"<?php endif; ?>>
  <div class="shade"></div>
  <div class="shade shade-extra"></div>

  <div class="container">

    <header class="entry-header">

      <div class="entry-meta">
        <p class="entry-time"><time datetime="<?php the_time('c'); ?>"><?php the_time('l') ?>na, <?php the_time('j.') ?><?php the_time('n.') ?><?php the_time('Y') ?></time></p>
      </div><!-- .entry-meta -->

      <?php
        if ( is_single() ) {
          the_title( '<h1 class="entry-title">', '</h1>' );
        } else {
          the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        }
      ?>

    </header><!-- .entry-header -->

  </div><!-- .container -->
</div>
