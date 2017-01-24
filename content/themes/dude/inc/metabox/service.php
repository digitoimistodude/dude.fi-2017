<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single service
 */
add_action( 'carbon_register_fields', 'dude_metabox_service' );
function dude_metabox_service() {
  $category_select = array( '0' => __( 'Valitse', 'dude' ) );
  $cats = get_terms( 'category' );
  foreach( $cats as $cat ) {
    $category_select[ $cat->term_id ] = $cat->name;
  }

  $service_select = array( '0' => __( 'Valitse', 'dude' ) );
  $services = get_terms( 'service' );
  foreach( $services as $service ) {
    $service_select[ $service->term_id ] = $service->name;
  }

  Container::make( 'post_meta', __( 'Lisäsisällön asetukset', 'dude' ) )
    ->show_on_post_type( 'service' )
    ->add_fields( array(
      Field::make( 'textarea', 'hero_desc', __( 'Otsikkoalueen leipäteksti', 'dude' ) ),

      Field::make( 'text', 'area_01_title', __( 'Ensimmäisen tekstialueen otsikko (01)', 'dude' ) ),

      Field::make( 'complex', 'advantages', __( 'Edut ja hyödyt gridi', 'dude' ) )
        ->add_fields( array(
            Field::make( 'text', 'title', __( 'Otsikko', 'dude' ) )
              ->set_width( 25 ),
            Field::make( 'textarea', 'content', __( 'Sisältö', 'dude' ) )
              ->set_width( 75 ),
        ) ),

      Field::make( 'text', 'area_02_title', __( 'Toisen tekstialueen otsikko (02)', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'text', 'area_02_list_title', __( 'Toisen tekstialueen listan otsikko (02)', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'separator', 'sep_1', __( 'Toisen teksialueen hintaelementti', 'dude' ) ),

      Field::make( 'text', 'area_02_price_desc', __( 'Tuote', 'dude' ) )
        ->set_width( 25 ),

      Field::make( 'text', 'area_02_price', __( 'Hinta', 'dude' ) )
        ->set_width( 25 ),

      Field::make( 'text', 'area_02_cta_text', __( 'Linkin teksti', 'dude' ) )
        ->set_width( 25 ),

      Field::make( 'text', 'area_02_cta_url', __( 'Linkin kohde', 'dude' ) )
        ->set_width( 25 ),

      Field::make( 'rich_text', 'area_02_content', __( 'Toisen tekstialueen sisältö (02)', 'dude' ) ),

      Field::make( 'complex', 'area_02_list', __( 'Toisen tekstialueen lista (02)', 'dude' ) )
        ->add_fields( array(
            Field::make( 'text', 'item', __( 'Rivi', 'dude' ) )
        ) ),
    ) );

  Container::make( 'post_meta', __( 'Dynaamisten sisältöalueiden asetukset', 'dude' ) )
    ->show_on_post_type( 'service' )
    ->add_fields( array(
      Field::make( 'text', 'blog_title', __( 'Blogin otsikko', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'select', 'blog_category', __( 'Blogin kategoria', 'dude' ) )
        ->add_options( $category_select )
        ->set_width( 50 ),

      Field::make( 'text', 'references_title', __( 'Referenssien otsikko', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'select', 'references_service', __( 'Minkä palvelun referenssit näytetään', 'dude' ) )
        ->add_options( $service_select )
        ->set_width( 50 ),

      Field::make( 'text', 'quote_title', __( 'Lainauksen otsikko', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'select', 'quote_service', __( 'Minkä palvelun lainaus näytetään', 'dude' ) )
        ->add_options( $service_select )
        ->set_width( 50 ),
    ) );
}
