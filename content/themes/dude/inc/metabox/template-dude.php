<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single reference
 */
add_action( 'carbon_register_fields', 'dude_metabox_template_dude' );
function dude_metabox_template_dude() {
  $category_select = array( '0' => __( 'Valitse', 'dude' ) );
  $cats = get_terms( 'category' );
  foreach( $cats as $cat ) {
    $category_select[ $cat->term_id ] = $cat->name;
  }

  Container::make( 'post_meta', __( 'Yläpalkin sisältö', 'dude' ) )
    ->show_on_post_type( 'page' )
    ->show_on_template( 'template-dude.php' )
    ->add_fields( array(
      Field::make( 'text', 'hero_title', __( 'Otsikko', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'textarea', 'hero_desc', __( 'Sisältö', 'dude' ) )
        ->set_width( 50 ),
    ) );

  Container::make( 'post_meta', __( 'Sisältöalueen asetukset', 'dude' ) )
    ->show_on_post_type( 'page' )
    ->show_on_template( 'template-dude.php' )
    ->add_fields( array(
      Field::make( 'text', 'persons_title', __( 'Henkilöiden otsikko', 'dude' ) ),

      Field::make( 'text', 'blog_title', __( 'Blogin otsikko', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'select', 'blog_category', __( 'Blogin kategoria', 'dude' ) )
        ->add_options( $category_select )
        ->set_width( 50 ),

      Field::make( 'separator', 'sep_1', '' ),

      Field::make( 'text', 'number_1_value', __( 'Ensimmäinen numero', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'text', 'number_1_label', __( 'Ensimmäinen selite', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'text', 'number_2_value', __( 'Toinen numero', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'text', 'number_2_label', __( 'Toinen selite', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'text', 'number_3_value', __( 'Kolmas numero', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'text', 'number_3_label', __( 'Kolmas selite', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'text', 'number_4_value', __( 'Neljäs numero', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'text', 'number_4_label', __( 'Neljäs selite', 'dude' ) )
        ->set_width( 50 ),
    ) );

  Container::make( 'post_meta', __( 'Arvot', 'dude' ) )
    ->show_on_post_type( 'page' )
    ->show_on_template( 'template-dude.php' )
    ->add_fields( array(
      Field::make( 'text', 'values_title', __( 'Otsikko', 'dude' ) ),

      Field::make( 'complex', 'values' )
        ->add_fields( array(
            Field::make( 'text', 'title', __( 'Otsikko', 'dude' ) )
              ->set_width( 25 ),
            Field::make( 'textarea', 'content', __( 'Sisältö', 'dude' ) )
              ->set_width( 75 ),
        ) ),
    ) );

}
