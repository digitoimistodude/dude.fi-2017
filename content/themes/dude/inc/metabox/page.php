<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single post
 */
add_action( 'carbon_register_fields', 'dude_metabox_page' );
function dude_metabox_page() {
  Container::make( 'post_meta', __( 'Blogin asetukset', 'dude' ) )
    ->show_on_page( get_option( 'page_for_posts' ) )
    ->add_fields( array(
      Field::make( 'textarea', 'desc', __( 'Johdanto', 'dude' ) )
        ->set_rows( 4 )
    ) );
}
