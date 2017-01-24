<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single post
 */
add_action( 'carbon_register_fields', 'dude_metabox_archive_reference' );
function dude_metabox_archive_reference() {
  Container::make( 'post_meta', __( 'Call To Action', 'dude' ) )
    ->show_on_page( get_option( 'page_for_reference' ) )
    ->add_fields( array(
      Field::make( 'rich_text', 'cta_content', __( 'Sisältö', 'dude' ) )
    ) );
}
