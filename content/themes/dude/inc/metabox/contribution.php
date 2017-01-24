<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single reference
 */
add_action( 'carbon_register_fields', 'dude_metabox_contribution' );
function dude_metabox_contribution() {
  Container::make( 'post_meta', __( 'Kontribuution asetukset', 'dude' ) )
    ->show_on_post_type( 'contribution' )
    ->add_fields( array(
      Field::make( 'select', 'contribution_type', __( 'Kontribuution tapa', 'dude' ) )
        ->add_options( array(
          '0'             => __( 'Valitse', 'dude' ),
          'plugin'        => __( 'Lisäosa', 'dude' ),
          'theme'         => __( 'Teema', 'dude' ),
          'devtool'       => __( 'Työkalu', 'dude' ),
          'community'     => __( 'Yhteisö', 'dude' ),
          'presentation'  => __( 'Esitys / keynote', 'dude' )
        ) ),

      Field::make( 'text', 'github_repo_owner', __( 'GitHub -repositoryn omistajan slugi', 'dude' ) )
        ->set_width( 50 )
        ->help_text( 'github.com/<b>digitoimistodude</b>/air' )
        ->set_default_value( 'digitoimistodude' )
        ->set_conditional_logic( array(
          array(
            'field'   => 'contribution_type',
            'value'   => array( 'plugin', 'theme', 'devtool' ),
            'compare' => 'IN'
          )
        ) ),

      Field::make( 'text', 'github_repo', __( 'GitHub -repositoryn slugi', 'dude' ) )
        ->set_width( 50 )
        ->help_text( 'github.com/digitoimistodude/<b>air</b>' )
        ->set_conditional_logic( array(
          array(
            'field'   => 'contribution_type',
            'value'   => array( 'plugin', 'theme', 'devtool' ),
            'compare' => 'IN'
          )
        ) ),

      Field::make( 'text', 'link', __( 'Linkki', 'dude' ) )
        ->set_width( 50 )
        ->set_conditional_logic( array(
          array(
            'field'   => 'contribution_type',
            'value'   => array( 'community', 'presentation' ),
            'compare' => 'IN'
          )
        ) ),

      Field::make( 'date', 'time', __( 'Ajankohta', 'dude' ) )
        ->set_width( 50 )
        ->set_conditional_logic( array(
          array(
            'field'   => 'contribution_type',
            'value'   => array( 'community', 'presentation' ),
            'compare' => 'IN'
          )
        ) ),

      Field::make( 'checkbox', 'link_to_blank', __( 'Avaa uuteen välilehteen', 'dude' ) )
        ->set_width( 50 )
        ->set_conditional_logic( array(
          array(
            'field'   => 'contribution_type',
            'value'   => array( 'community', 'presentation' ),
            'compare' => 'IN'
          )
        ) ),
    ) );
}
