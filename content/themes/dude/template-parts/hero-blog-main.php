<?php
/**
 * Blog hero template file.
 *
 * This is the default hero image for page templates, called
 * 'slide'. Strictly dude specific.
 *
 * @package dude
 */

$desc = get_post_meta( get_option( 'page_for_posts' ), '_desc', true );
if( is_archive() && !empty( term_description() ) ) {
  $desc = term_description();
}
?>

<div class="slide slide-hero slide-hero-main-blog" style="background-image:url('<?php echo get_template_directory_uri(); ?>/images/typewriter-1.jpg');">
  <div class="shade"></div>
  <div class="shade shade-extra"></div>

  <div class="container">

    <header class="entry-header">

      <?php if( is_archive() ): ?>
        <h1 class="entry-title"><?php the_archive_title() ?></h1>
      <?php else: ?>
        <h1 class="entry-title"><?php echo get_the_title( get_option( 'page_for_posts' ) ) ?></h1>
      <?php endif; ?>

      <div class="blog-description">
        <?php if( !empty( $desc ) ):
          echo wpautop( $desc );
        endif; ?>
      </div>

    </header><!-- .entry-header -->

  </div><!-- .container -->
</div>
