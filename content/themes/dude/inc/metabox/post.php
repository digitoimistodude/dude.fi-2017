<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single post
 */
add_action( 'carbon_register_fields', 'dude_metabox_post' );
function dude_metabox_post() {
  Container::make( 'post_meta', __( 'Blogirullan asetukset', 'dude' ) )
    ->show_on_post_type( 'post' )
    ->add_fields( array(
      Field::make( 'textarea', 'scroller_excerpt', __( 'Johdanto', 'dude' ) )
        ->set_rows( 4 )
    ) );
}
