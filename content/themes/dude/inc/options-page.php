<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'theme_options', __( 'Teeman asetukset', 'dude' ) )
  ->set_page_parent( 'themes.php' )
  ->add_fields( array(
    Field::make( 'separator', 'theme_options_company', __( 'Yhteystiedot', 'dude' ) ),

    Field::make( 'text', 'dude_contact_company_name', __( 'Viriman nimi', 'dude' ) )
      ->set_width( 33 ),

    Field::make( 'text', 'dude_contact_company_business_id', __( 'Y-tunnus', 'dude' ) )
      ->set_width( 33 ),

    Field::make( 'text', 'dude_contact_email', __( 'Sähköposti', 'dude' ) )
      ->set_width( 33 ),

    Field::make( 'text', 'dude_contact_address_row1', __( 'Osoiterivi 1', 'dude' ) )
      ->set_width( 50 ),

    Field::make( 'text', 'dude_contact_address_row2', __( 'Osoiterivi 2', 'dude' ) )
      ->set_width( 50 ),

    Field::make( 'separator', 'theme_options_footer', __( 'Alapalkki', 'dude' ) ),

    Field::make( 'text', 'dude_contact_person_title', __( 'Yhteyshenkilön otsikko', 'dude' ) )
      ->set_width( 25 ),

    Field::make( 'text', 'dude_contact_person_name', __( 'Nimi', 'dude' ) )
      ->set_width( 25 ),

    Field::make( 'text', 'dude_contact_person_email', __( 'Sähköposti', 'dude' ) )
      ->set_width( 25 ),

    Field::make( 'text', 'dude_contact_person_phone', __( 'Puhelin', 'dude' ) )
      ->set_width( 25 ),

    Field::make( 'text', 'dude_support_title', __( 'Tuen otsikko', 'dude' ) )
      ->set_width( 25 ),

    Field::make( 'text', 'dude_support_email', __( 'Sähköposti', 'dude' ) )
      ->set_width( 25 ),

    Field::make( 'text', 'dude_support_phone', __( 'Puhelin', 'dude' ) )
      ->set_width( 25 ),

    Field::make( 'checkbox', 'dude_support_show_chat', __( 'Näytä chat-nappi', 'dude' ) )
      ->set_width( 25 ),

    Field::make( 'text', 'dude_contact_title', __( 'Viriman tietojen otsikko', 'dude' ) ),

    Field::make( 'text', 'dude_social_title', __( 'Sosiaaliset meediot otsikko', 'dude' ) )
      ->set_width( 50 ),

    Field::make( 'text', 'dude_social_bottomline', __( 'Sosiaaliset meediot alarivi', 'dude' ) )
      ->set_width( 50 ),

    Field::make( 'complex', 'dude_social_links', __( 'Sosiaaliset meediot', 'dude' ))
      ->add_fields( array(
        Field::make( 'text', 'url', __( 'Osoite', 'dude' ) )
          ->set_width( 50 ),
        Field::make( 'text', 'content', __( 'Teksti', 'dude' ) )
          ->set_width( 50 ),
      ) )
) );
