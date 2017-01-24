<?php

$labels = array(
	'name'               => _x( 'Palvelut', 'post type general name', 'dude' ),
	'singular_name'      => _x( 'Palvelu', 'post type singular name', 'dude' ),
	'menu_name'          => _x( 'Palvelut', 'admin menu', 'dude' ),
	'name_admin_bar'     => _x( 'Palvelu', 'add new on admin bar', 'dude' ),
	'add_new'            => _x( 'Lisää uusi', 'example', 'dude' ),
	'add_new_item'       => __( 'Lisää uusi palvelu', 'dude' ),
	'new_item'           => __( 'Uusi palvelu', 'dude' ),
	'edit_item'          => __( 'Muokkaa palvelua', 'dude' ),
	'view_item'          => __( 'Katsele palvelua', 'dude' ),
	'all_items'          => __( 'Kaikki palvelut', 'dude' ),
	'search_items'       => __( 'Etsi palveluita', 'dude' ),
	'parent_item_colon'  => __( 'Palvelun isäntä:', 'dude' ),
	'not_found'          => __( 'Palveluita ei löytynyt.', 'dude' ),
	'not_found_in_trash' => __( 'Palveluita ei löytynyt roskista.', 'dude' )
);

$args = array(
	'labels'             => $labels,
	'public'             => true,
	'publicly_queryable' => true,
	'show_ui'            => true,
	'show_in_menu'       => true,
	'query_var'          => true,
  'rewrite'            => array( 'slug' => false, 'with_front' => false ),
	'capability_type'    => 'post',
	'has_archive'        => false,
	'hierarchical'       => false,
	'menu_position'      => null,
  'menu_icon'          => 'dashicons-hammer',
	'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
);

register_post_type( 'service', $args );
