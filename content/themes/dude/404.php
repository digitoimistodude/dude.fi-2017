<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package dude
 */

get_header(); ?>

<div id="page">

  <div class="site-content">

    <div id="primary" class="content-area" style="background-image:url('<?php echo get_theme_file_uri( 'images/404.gif' ) ?>')">

      <div class="slide slide-notfound">

        <div class="shade"></div>
        <div class="shade shade-extra"></div>

        <div class="container container-not-found">
          <h1><?php _e( 'Voi prkl! 404! 666!', 'dude'); ?></h1>
          <p><?php _e( 'Nyt meni perseelleen! Sivua tai tiedostoa ei löydy, eikä täällä ei ole mitään nähtävää, sori!', 'dude' ); ?></p>

          <p><a href="/" class="button button-white"><?php _e( 'Siirry etusivulle', 'dude' ); ?></a></p>
        </div>

        </div><!-- .container -->

      </div><!-- .slide -->

  	</div><!-- #primary -->

	</div>

</div>

  <script>
    var options = {
      "animate": true,
      "patternWidth": 177.5,
      "patternHeight": 280.16,
      "grainOpacity": 0.18,
      "grainDensity": 1.3,
      "grainWidth": 1.6,
      "grainHeight": 1.5
    }

    grained("#primary", options);
  </script>
