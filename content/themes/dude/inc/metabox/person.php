<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *  Add metaboxes for single post
 */
add_action( 'carbon_register_fields', 'dude_metabox_person' );
function dude_metabox_person() {
  // Get refrences for select purposes
  $query = new WP_Query( array(
    'post_type'               => 'reference',
    'posts_per_page'          => 100,
    'no_found_rows'           => true,
    'update_post_meta_cache'  => false,
    'update_post_term_cache'  => false
  ) );

  $reference_select = array( '0' => __( 'Valitse', 'dude' ) );
  if( $query->have_posts() ):
    while( $query->have_posts() ):
      $query->the_post();
      $reference_select[ get_the_id() ] = get_the_title();
    endwhile;
  endif; wp_reset_postdata();

  // Get users for select purposes
  $users = get_users( array(
    'number'  => 10,
    'orderby' => 'display_name',
    'fields'  => array( 'ID', 'display_name' )
  ) );
  $users_select = array( '0' => __( 'Valitse', 'dude' ) );
  foreach( $users as $user ) {
    $users_select[ $user->ID ] = $user->display_name;
  }

  Container::make( 'post_meta', __( 'Henkilöesittelyn lisäsisältö', 'dude' ) )
    ->show_on_post_type( 'person' )
    ->add_fields( array(
      Field::make( 'select', 'project_upsell', __( 'Mieluisin projekti', 'dude' ) )
        ->add_options( $reference_select )
        ->set_width( 33 ),

      Field::make( 'select', 'linked_user', __( 'Linkitetty käyttäjätunnus', 'dude' ) )
        ->add_options( $users_select )
        ->set_width( 33 ),

      Field::make( 'text', 'handle_instagram', __( 'Instagram -tunnuksen ID', 'dude' ) )
        ->set_width( 33 ),

      Field::make( 'text', '2col_title', __( 'Kahden palstan otsikko', 'dude' ) ),

      Field::make( 'rich_text', 'col1', __( 'Ensimmäinen palsta', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'rich_text', 'col2', __( 'Toinen palsta', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'image', 'image1', __( 'Ensimmäinen kuva', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'image', 'image2', __( 'Toinen kuva', 'dude' ) )
        ->set_width( 50 ),

      Field::make( 'text', 'numbers_title', __( 'Numeroiden', 'dude' ) )
        ->set_width( 70 ),

      Field::make( 'image', 'numbers_image', __( 'Numeroiden taustakuva', 'dude' ) )
        ->set_width( 30 ),

      Field::make( 'complex', 'numbers', __( 'Numerot', 'dude' ) )
        ->set_max( 4 )
        ->add_fields( array(
          Field::make( 'select', 'type', __( 'Lähde', 'dude' ) )
            ->add_options( array( '0' => __( 'Valitse', 'dude' ), 'dynamic' => __( 'Dynaaminen', 'dude' ), 'static' => __( 'Staattinen', 'dude' ) ) )
            ->set_width( 15 ),

          Field::make( 'select', 'dynamic', __( 'Dynaaminen lähde', 'dude' ) )
            ->set_width( 15 )
            ->set_conditional_logic( array(
              array(
                'field' => 'type',
                'value' => 'dynamic'
              )
            ) )
            ->add_options( array(
              'twitter-followers' => __( 'Twitter seuraajat', 'dude' ),
              'untappd'           => __( 'Untappd', 'dude' ),
              'todoist'           => __( 'Todoist', 'dude' ),
              'github'            => __( 'GitHub', 'dude' ),
              'wakatime'          => __( 'WakaTime', 'dude' ),
              'timefrom'          => __( 'Aikaa siitä kuin', 'dude' )
            ) ),

          Field::make( 'text', 'label', __( 'Selite', 'dude' ) )
            ->set_width( 17.5 ),

          Field::make( 'text', 'below_label', __( 'Seliteen toinen rivi', 'dude' ) )
            ->set_width( 17.5 )
            ->set_conditional_logic( array(
              array(
                'field' => 'type',
                'value' => 'static'
              )
            ) ),

          Field::make( 'text', 'value', __( 'Arvo', 'dude' ) )
            ->set_width( 17.5 )
            ->set_conditional_logic( array(
              array(
                'field' => 'type',
                'value' => 'static'
              )
            ) ),

            Field::make( 'text', 'username', __( 'Käyttäjätunniste', 'dude' ) )
              ->set_width( 17.5 )
              ->set_conditional_logic( array(
                array(
                  'field' => 'type',
                  'value' => 'dynamic'
                )
              ) ),
        ) ),
    ) );

  Container::make( 'post_meta', __( 'Henkilön yhteystiedot', 'dude' ) )
    ->show_on_post_type( 'person' )
    ->add_fields( array(
      Field::make( 'text', 'job_title', __( 'Titteli(t)', 'dude' ) )
        ->set_width( 33 ),

      Field::make( 'text', 'email', __( 'Sähköposti', 'dude' ) )
        ->set_width( 33 ),

      Field::make( 'text', 'phone', __( 'Puhelin', 'dude' ) )
        ->set_width( 33 ),

      Field::make( 'complex', 'social', __( 'Sosiaalisen median linkit', 'dude' ) )
        ->add_fields( array(
          Field::make( 'text', 'service', __( 'Palvelu', 'dude' ) )
            ->help_text( __( 'Käytetään myös li-elementin luokkana ja ikonin tiedostonimenä', 'dude' ) )
            ->set_width( 50 ),

          Field::make( 'text', 'url', __( 'Osoite', 'dude' ) )
            ->set_width( 50 ),
        ) ),
    ) );

  Container::make( 'post_meta', __( 'Henkilön lainaus', 'dude' ) )
    ->show_on_post_type( 'person' )
    ->add_fields( array(
      Field::make( 'textarea', 'quote', __( 'Lainaus', 'dude' ) )
        ->set_width( 70 ),

      Field::make( 'image', 'quote_image', __( 'Lainauksen kuva', 'dude' ) )
        ->set_width( 30 ),
    ) );
}
