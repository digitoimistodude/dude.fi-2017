<?php

add_action( 'rest_api_init', function () {
	register_rest_route( 'dude/v1', '/post/(?P<page>\d+)/like', array(
		'methods'   => 'GET',
		'callback'  => 'dude_like_callback',
	) );

  register_rest_route( 'dude/v1', '/post/(?P<page>\d+)/unlike', array(
		'methods'   => 'GET',
		'callback'  => 'dude_unlike_callback',
	) );
} );

function dude_like_callback( $request ) {
  $parameters = $request->get_url_params();

  $like_count = get_post_meta( $parameters['page'], '_post_like_count', true );
  $like_count = intval( $like_count );
  $like_count++;

  update_post_meta( $parameters['page'], '_post_like_count', $like_count );

  return array( 'status' => 'success', 'count' => $like_count, 'post_id' => $parameters['page'] );
}

function dude_unlike_callback( $request ) {
  $parameters = $request->get_url_params();

  $like_count = get_post_meta( $parameters['page'], '_post_like_count', true );
  $like_count = intval( $like_count );
  $like_count--;

  update_post_meta( $parameters['page'], '_post_like_count', $like_count );

  return array( 'status' => 'success', 'count' => $like_count, 'post_id' => $parameters['page'] );
}
