<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package dude
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#fff">

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/apple-touch-icon.png">
<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicons/manifest.json">

<script>
  (function(h,o,t,j,a,r){
    h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
    h._hjSettings={hjid:8741,hjsv:5};
    a=o.getElementsByTagName('head')[0];
    r=o.createElement('script');r.async=1;
    r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
    a.appendChild(r);
  })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
</script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
  <?php if ( ! is_404() ) : ?>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'dude' ); ?></a>

	<header id="masthead" class="site-header <?php if( is_singular( 'reference' ) || get_post_type() == 'reference' ) : echo 'inverted'; endif; ?>">

		<div class="container">

			<div class="site-branding">
				<?php if( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if( $description || is_customize_preview() ) : ?>
					<p class="site-description screen-reader-text"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->

      <a href="tel:<?php echo str_replace( ' ', '', get_option( 'dude_contact_person_phone' ) ) ?>" title="<?php _e( 'Soita meille', 'dude' ) ?>" class="button call-me-maybe"><?php _e( 'Soita', 'dude' ) ?></a>

      <button id="nav-trigger" class="nav-trigger" aria-controls="nav"><span class="burger-icon"></span><span class="nav-toggle-label screen-reader-text"><?php esc_html_e( 'Valikko', 'dude' ); ?></span></button>

			<nav id="nav" class="nav-collapse s-container ps-active-y" aria-expanded="false" tabindex="-1">

				<?php wp_nav_menu( array(
					'theme_location'    => 'primary',
					'container'       	=> false,
					'depth'             => 4,
					'menu_class'        => 'menu-items',
					'menu_id' 					=> 'menu',
					'echo'            	=> true,
					'fallback_cb'       => 'wp_page_menu',
					'items_wrap'      	=> '<ul class="%2$s" id="%1$s">%3$s</ul>',
					'walker'            => new dude_Walker(),
				) ); ?>

			</nav><!-- #site-navigation -->

		</div><!-- .container -->
	</header><!-- #masthead -->

  <div class="site-wrapper">
	  <div id="content" class="site-content">

    <?php endif; ?>
