<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single reference
 */
add_action( 'carbon_register_fields', 'dude_metabox_reference' );
function dude_metabox_reference() {
  Container::make( 'post_meta', __( 'Kiinnitä etusivun pääreferenssiksi', 'dude' ) )
    ->show_on_post_type( 'reference' )
    ->set_context( 'side' )
    ->add_fields( array(
      Field::make( 'checkbox', 'pool_upsell', __( 'Kiinnitä', 'dude' ) )
    ) );

  Container::make( 'post_meta', __( 'Referenssin yleiset asetukset', 'dude' ) )
    ->show_on_post_type( 'reference' )
    ->add_fields( array(
      Field::make( 'text', 'alt_title', __( 'Otsikko', 'dude' ) )
        ->set_width( 70 ),

      Field::make( 'text', 'svg_logo_filename', __( 'Logotiedoston nimi', 'dude' ) )
        ->set_width( 30 )
        ->help_text( __( 'Ilman logo- alkua ja tiedostopäätettä', 'dude' ) ),

      Field::make( 'text', 'site_url', __( 'Sivuston osoite', 'dude' ) )
        ->set_width( 33 ),

      Field::make( 'checkbox', 'show_general', __( 'Näytä alun teksti', 'dude' ) )
        ->set_width( 33 )
        ->help_text( __( 'Alun tekstinä käytetään tekstieditorin sisältöä', 'dude' ) ),

      Field::make( 'text', 'sub_title_general', __( 'Alun tekstin alueotsikko', 'dude' ) )
        ->set_width( 33 )
        ->set_conditional_logic( array(
          array(
            'field'   => 'show_general',
            'value'   => 'yes'
          )
        ) ),
    ) );

  Container::make( 'post_meta', __( 'Lainaus', 'dude' ) )
    ->show_on_post_type( 'reference' )
    ->add_fields( array(
      Field::make( 'textarea', 'quote', __( 'Teksti', 'dude' ) ),

      Field::make( 'text', 'quote_name', __( 'Nimi', 'dude' ) )
        ->set_width( 33 ),

      Field::make( 'text', 'quote_title', __( 'Titteli', 'dude' ) )
        ->set_width( 33 ),

      Field::make( 'image', 'quote_image', __( 'Kuva', 'dude' ) )
        ->set_width( 33 ),
    ) );

  Container::make( 'post_meta', __( 'Referenssin dynaaminen esittely', 'dude' ) )
    ->show_on_post_type( 'reference' )
    ->add_fields( array(
      Field::make( 'complex', 'parts' )
        ->add_fields( array(

          // Field for template select
          Field::make( 'select', 'template', __( 'Osion pohja', 'dude' ) )
            ->add_options( array(
              '0'                       => __( 'Valitse', 'dude' ),
              'text'                    => __( 'Keskitetty teksti', 'dude' ),
              'text-col'                => __( 'Teksti kahdessa palstassa', 'dude' ),
              'text-image'              => __( 'Teksti oikealla kuvalla', 'dude' ),
              'text-bg-image'           => __( 'Teksti taustakuvalla', 'dude' ),
              'text-bg-image-centered'  => __( 'Keskitetty teksti taustakuvalla', 'dude' ),
              'images'                  => __( 'Kuvagalleria', 'dude' ),
              'before-after'            => __( 'Ennen - jälkeen kuvat', 'dude' ),
              'image'                   => __( 'Kuva', 'dude' ),
              'video'                   => __( 'Video', 'dude' ),
              'numbers'                 => __( 'Avainluvut', 'dude' ),
              'quote'                   => __( 'Lainaus', 'dude' ),
              'link'                    => __( 'Linkki toteutukseen', 'dude' )
            ) ),

          // More general sub fields
          Field::make( 'text', 'sub_title', __( 'Alueen otsikko', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => array( 'text-bg-image', 'text-bg-image-centered', 'text-col', 'text-image', 'text', 'numbers', 'quote' ),
                'compare' => 'IN'
              )
            ) ),

          // Fields for text-bg-image, text-image, text and
          Field::make( 'image', 'image', __( '(Tausta)kuva', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => array( 'text-bg-image', 'text-bg-image-centered', 'text-image', 'image' ),
                'compare' => 'IN'
              )
            ) ),

          Field::make( 'rich_text', 'content', __( 'Sisältö', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => array( 'text-bg-image', 'text-bg-image-centered', 'text-image', 'text' ),
                'compare' => 'IN'
              )
            ) ),

          Field::make( 'color', 'content_color', __( 'Teksin väri', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => array( 'text-bg-image', 'text-bg-image-centered' ),
                'compare' => 'IN'
              )
            ) ),

          // Fields for images
          Field::make( 'checkbox', 'lift_up', __( 'Nosta edellisen alueen päälle', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field' => 'template',
                'value' => 'images',
              )
            ) ),

          Field::make( 'complex', 'images', __( 'Kuvat', 'dude' ) )
            ->add_fields( array(
              Field::make( 'image', 'image', __( 'Kuva', 'dude' ) ),
            ) )
            ->set_conditional_logic( array(
              array(
                'field' => 'template',
                'value' => 'images',
              )
            ) ),

          // Fields for 2col text
          Field::make( 'text', 'title', __( 'Otsikko', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field' => 'template',
                'value' => 'text-col',
              )
            ) ),

          Field::make( 'rich_text', 'col1', __( 'Teksti vasemmalla', 'dude' ) )
            ->set_width( 50 )
            ->set_conditional_logic( array(
              array(
                'field' => 'template',
                'value' => 'text-col',
              )
            ) ),

          Field::make( 'rich_text', 'col2', __( 'Teksti oikealla', 'dude' ) )
            ->set_width( 50 )
            ->set_conditional_logic( array(
              array(
                'field' => 'template',
                'value' => 'text-col',
              )
            ) ),

          // Fields for before and after
          Field::make( 'color', 'bg_color', __( 'Taustaväri', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field' => 'template',
                'value' => 'before-after',
              )
            ) ),

          Field::make( 'text', 'label1', __( 'Ensimmäinen otsikko', 'dude' ) )
            ->set_width( 50 )
            ->set_default_value( __( 'Ennen', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field' => 'template',
                'value' => 'before-after',
              )
            ) ),

          Field::make( 'text', 'label2', __( 'Toinen otsikko', 'dude' ) )
            ->set_width( 50 )
            ->set_default_value( __( 'Jälkeen', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field' => 'template',
                'value' => 'before-after',
              )
            ) ),

          Field::make( 'image', 'image1', __( 'Ensimmäinen kuva', 'dude' ) )
            ->set_width( 50 )
            ->set_conditional_logic( array(
              array(
                'field' => 'template',
                'value' => 'before-after',
              )
            ) ),

          Field::make( 'image', 'image2', __( 'Toinen kuva', 'dude' ) )
            ->set_width( 50 )
            ->set_conditional_logic( array(
              array(
                'field' => 'template',
                'value' => 'before-after',
              )
            ) ),

          // Fields for image
          Field::make( 'checkbox', 'wide_img', __( 'Leveä kuva', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => 'image',
              )
            ) ),

          // Fields for video
          Field::make( 'text', 'video', __( 'Videotiedoston nimi', 'dude' ) )
            ->help_text( __( 'Varmista että videoista on mp4, webm ja ogv formaatit.', 'dude' ) )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => 'video',
              )
            ) ),

          // Fields for numbers
          Field::make( 'text', 'number1_value', __( 'Ensimmäinen numero', 'dude' ) )
            ->set_width( 20 )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => 'numbers',
              )
            ) ),

          Field::make( 'text', 'number1_format', __( 'Formaatti', 'dude' ) )
            ->set_width( 10 )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => 'numbers',
              )
            ) ),

          Field::make( 'text', 'number1_label', __( 'Selite', 'dude' ) )
            ->set_width( 45 )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => 'numbers',
              )
            ) ),

          Field::make( 'date', 'number1_updated', __( 'Päivitetty', 'dude' ) )
            ->set_width( 25 )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => 'numbers',
              )
            ) ),

          Field::make( 'text', 'number2_value', __( 'Toinen numero', 'dude' ) )
            ->set_width( 20 )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => 'numbers',
              )
            ) ),

          Field::make( 'text', 'number2_format', __( 'Formaatti', 'dude' ) )
            ->set_width( 10 )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => 'numbers',
              )
            ) ),

          Field::make( 'text', 'number2_label', __( 'Selite', 'dude' ) )
            ->set_width( 45 )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => 'numbers',
              )
            ) ),

          Field::make( 'date', 'number2_updated', __( 'Päivitetty', 'dude' ) )
            ->set_width( 25 )
            ->set_conditional_logic( array(
              array(
                'field'   => 'template',
                'value'   => 'numbers',
              )
            ) ),
      ) ),
    ) );
}
