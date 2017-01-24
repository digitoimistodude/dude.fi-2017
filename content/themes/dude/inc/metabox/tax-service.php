<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single reference
 */
add_action( 'carbon_register_fields', 'dude_metabox_tax_service' );
function dude_metabox_tax_service() {
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

  // We might have some services given to reference, wihout that we have a spesific page to
  // tell about that service. So link to service page only when it's selected from here.
  Container::make( 'term_meta', __( 'Palvelu -termin lisätiedot', 'dude' ) )
    ->show_on_taxonomy( 'service' )
    ->add_fields( array(
      Field::make( 'select', 'service_page_id', __( 'Vastaava palvelusivu', 'dude' ) )
        ->help_text( __( 'Jos asetettu, tehdään palvelun nimestä linkki palvelusivulle.', 'dude' ) )
        ->add_options( $services_select )
    ) );
}
