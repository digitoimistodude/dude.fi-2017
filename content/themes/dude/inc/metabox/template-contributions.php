<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single reference
 */
add_action( 'carbon_register_fields', 'dude_metabox_template_contributions' );
function dude_metabox_template_contributions() {
  Container::make( 'post_meta', __( 'Lisäsisältö', 'dude' ) )
    ->show_on_post_type( 'page' )
    ->show_on_template( 'template-contributions.php' )
    ->add_fields( array(
      Field::make( 'textarea', 'hero_desc', __( 'Yläpalkin teksti', 'dude' ) ),
      Field::make( 'text', 'techniques_title', __( 'Tekniikoiden otsikko', 'dude' ) )
        ->set_width( 50 ),
      Field::make( 'text', 'contributions_title', __( 'Kontribuutioiden otsikko', 'dude' ) )
        ->set_width( 50 ),
    ) );
}
