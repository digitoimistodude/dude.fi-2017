<?php

function dude_get_coffee_drunk() {
  $transient_name = 'dude_coffter_week';
	$data = get_transient( $transient_name );
  if( !empty( $data ) || false != $data )
    return $data;

  $response = wp_remote_get( 'http://coffter.dude.fi/v1/coffee/drunk/week' );
	if( $response['response']['code'] !== 200 )
		return false;

  set_transient( $transient_name, json_decode( $response['body'], true ), 600 );
	return json_decode( $response['body'], true );
}

function dude_get_post_likes( $post_id = null ) {
  if( empty( $post_id ) )
    return '0';

  $likes = get_post_meta( $post_id, '_post_like_count', true );
  if( empty( $likes ) )
    $likes = '0';

  return $likes;
}
