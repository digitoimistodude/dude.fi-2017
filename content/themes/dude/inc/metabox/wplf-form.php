<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single wplf form
 */
add_action( 'carbon_register_fields', 'dude_metabox_wplf_form' );
function dude_metabox_wplf_form() {
  Container::make( 'post_meta', __( 'Interaktiivisen lomakkeen asetukset', 'dude' ) )
    ->show_on_page( 2048 )
    ->show_on_post_type( 'wplf-form' )
    ->add_fields( array(
      Field::make( 'text', 'sayatme_message', __( 'Viesti nimen syötön jälkeen', 'dude' ) )
        ->help_text( __( '{{ name }} korvataan syötetyllä nimellä', 'dude' ) ),
      Field::make( 'text', 'sayatme_email', __( 'Viesti viestikentän täytön jälkeen', 'dude' ) ),
      Field::make( 'text', 'sayatme_phone', __( 'Viesti sähköpostiosoitteen syötön jälkeen', 'dude' ) ),
    ) );
}
