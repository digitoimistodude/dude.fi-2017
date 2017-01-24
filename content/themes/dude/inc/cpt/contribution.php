<?php

$labels = array(
	'name'               => _x( 'Kontribuutiot', 'post type general name', 'dude' ),
	'singular_name'      => _x( 'Kontribuutio', 'post type singular name', 'dude' ),
	'menu_name'          => _x( 'Kontribuutiot', 'admin menu', 'dude' ),
	'name_admin_bar'     => _x( 'Kontribuutio', 'add new on admin bar', 'dude' ),
	'add_new'            => _x( 'Lisää uusi', 'example', 'dude' ),
	'add_new_item'       => __( 'Lisää uusi kontribuutio', 'dude' ),
	'new_item'           => __( 'Uusi kontribuutio', 'dude' ),
	'edit_item'          => __( 'Muokkaa kontribuutiota', 'dude' ),
	'view_item'          => __( 'Katsele kontribuutiota', 'dude' ),
	'all_items'          => __( 'Kaikki kontribuutiot', 'dude' ),
	'search_items'       => __( 'Etsi kontribuutioita', 'dude' ),
	'parent_item_colon'  => __( 'Kontribuution isäntä:', 'dude' ),
	'not_found'          => __( 'Kontribuutioita ei löytynyt.', 'dude' ),
	'not_found_in_trash' => __( 'Kontribuutioita ei löytynyt roskista.', 'dude' )
);

$args = array(
	'labels'             => $labels,
	'public'             => false,
	'publicly_queryable' => false,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'query_var'          => true,
	'rewrite'            => array( 'slug' => __( 'kontribuutiot', 'dude' ) ),
	'capability_type'    => 'post',
	'has_archive'        => false,
	'hierarchical'       => false,
	'menu_position'      => null,
  'menu_icon'          => 'dashicons-heart',
	'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes' )
);

register_post_type( 'contribution', $args );
