<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for front page
 */
add_action( 'carbon_register_fields', 'dude_metabox_front_page' );
function dude_metabox_front_page() {
  $fp_id = get_option( 'page_on_front' );

  // Get services for select purposes
  $query = new WP_Query( array(
    'post_type'               => 'service',
    'posts_per_page'          => 50,
    'no_found_rows'           => true,
    'update_post_meta_cache'  => false,
    'update_post_term_cache'  => false
  ) );

  $services_select = array( '0' => __( 'Valitse', 'dude' ) );
  if( $query->have_posts() ):
    while( $query->have_posts() ):
      $query->the_post();
      $services_select[ get_the_id() ] = get_the_title();
    endwhile;
  endif; wp_reset_postdata();

  // Hero content metabox
  Container::make( 'post_meta', __( 'Herokuvan sisältö', 'dude' ) )
    ->show_on_page( $fp_id )
    ->add_fields( array(
      Field::make( 'text', 'fp_hero_title', __( 'Otsikko', 'dude' ) ),
      Field::make( 'textarea', 'fp_hero_content', __( 'Sisältö', 'dude' ) ),
      Field::make( 'text', 'fp_hero_button', __( 'Napin teksti', 'dude' ) )
        ->set_width( 50 ),
      Field::make( 'text', 'fp_hero_button_url', __( 'Napin osoite', 'dude' ) )
        ->set_width( 50 )
    ) );

  // Intro additional content metabox
  Container::make( 'post_meta', __( 'Esittelyn valinnainen sisältö', 'dude' ) )
    ->show_on_page( $fp_id )
    ->add_fields( array(
      Field::make( 'select', 'fp_wordpress_page_id', __( 'Verkkosivut palvelun sivu', 'dude' ) )
        ->add_options( $services_select )
        ->set_width( 50 ),
      Field::make( 'select', 'fp_woocommerce_page_id', __( 'Verkkokaupat palvelun sivu', 'dude' ) )
        ->add_options( $services_select )
        ->set_width( 50 ),
    ) );

  // Dynamic content area titles metabox
  Container::make( 'post_meta', __( 'Dynaamisten sisältöalueiden otsikot', 'dude' ) )
    ->show_on_page( $fp_id )
    ->add_fields( array(
      Field::make( 'text', 'fp_references_title', __( 'Referenssit', 'dude' ) ),
      Field::make( 'text', 'fp_clients_title', __( 'Asiakkaat', 'dude' ) ),
      Field::make( 'text', 'fp_blog_title', __( 'Blogi', 'dude' ) ),
    ) );
}
