<?php
/**
 * Person hero template file.
 *
 * This is the default hero image for page templates, called
 * 'slide'. Strictly dude specific.
 *
 * @package dude
 */

$job_title = get_post_meta( get_the_id(), '_job_title', true );
$email = get_post_meta( get_the_id(), '_email', true );
$phone = get_post_meta( get_the_id(), '_phone', true );
$social = carbon_get_post_meta( get_the_id(), '_social', 'complex' );

?>

<div class="slide slide-hero slide-hero-person" <?php if ( has_post_thumbnail() ) : ?> style="background-image:url('<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id() ) ); ?>');"<?php endif; ?>>
  <div class="shade"></div>
  <div class="shade shade-extra"></div>

  <div class="container">

    <h1><?php the_title(); ?></h1>
    <?php if( !empty( $job_title ) ): ?>
      <h2><?php echo $job_title ?></h2>
    <?php endif; ?>

    <ul class="contact-information">
      <?php if( !empty( $email ) ): ?>
        <li><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a></li>
      <?php endif;

      if( !empty( $phone ) ): ?>
        <li><a href="tel:<?php echo str_replace( ' ', '', $phone ) ?>"><?php echo $phone ?></a></li>
      <?php endif; ?>
    </ul>

    <?php if( !empty( $social ) ): ?>
      <ul class="some">
        <?php foreach( $social as $some ):
          if( empty( $some['service'] ) || empty( $some['url'] ) )
            continue; ?>
          <li class="<?php echo strtolower( sanitize_title( $some['service'] ) ) ?>"><a href="<?php echo $some['url'] ?>" target="_blank"><?php echo file_get_contents( get_theme_file_path('svg/'.strtolower( sanitize_title( $some['service'] ) ).'.svg') ); ?><span class="screen-reader-text"><?php echo $some['service'] ?></span></a></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

  </div><!-- .container -->
</div>
