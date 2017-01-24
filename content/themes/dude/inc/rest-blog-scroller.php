<?php

add_action( 'rest_api_init', function () {
	register_rest_route( 'dude/v1', '/posts/(?P<page>\d+)', array(
		'methods'   => 'GET',
		'callback'  => 'dude_blog_scroller_callback',
	) );

  register_rest_route( 'dude/v1', '/posts/(?P<page>\d+)/(?P<cat>\d+)', array(
		'methods'   => 'GET',
		'callback'  => 'dude_blog_scroller_callback',
	) );
} );

function dude_blog_scroller_callback( $data ) {
  $args = array(
	  'paged'          => $data['page'],
	  'post_type'      => 'post',
	  'post_status'    => 'publish',
	  'no_found_rows'  => true
	);

  if( isset( $data['cat'] ) ) {
    $args['cat'] = $data['cat'];
  }

  if( isset( $data['archive'] ) && isset( $data['archive_id'] ) ) {
    if( $data['archive'] === 'category' ) {
      $args['cat'] = $data['archive_id'];
    } elseif( $data['archive'] === 'tag' ) {
      $args['tag_id'] = $data['archive_id'];
    } elseif( $data['archive'] === 'author' ) {
      $args['author'] = $data['archive_id'];
    }
  }

	$query = new WP_Query( $args );

	if( $query->have_posts() ):
    $posts = array();
    $i = 1; $y = 1;

	  while( $query->have_posts() ):
	    $query->the_post();

      if( $i % 2 != 0 ) {
        if( $y % 2 != 0 ) {
          $class = 'mosaic-narrow';
        } else {
          $class = 'mosaic-wide';
        }
      } else {
        if( $y % 2 != 0 ) {
          $class = 'mosaic-wide';
        } else {
          $class = 'mosaic-narrow';
        }

        $y++;
      }

      $i++;

      $excerpt = get_post_meta( get_the_id(), '_scroller_excerpt', true );
      if( empty( $excerpt ) ) {
        $sentence = preg_match('/^([^.!?]*[\.!?]+){0,1}/', strip_tags( get_the_content() ), $summary);
        $excerpt = strip_shortcodes( $summary[0] );
      }

      $author_avatar = '';
      if( function_exists('get_avatar_url') ):
        $author_avatar = get_avatar_url( get_the_author_meta( 'email' ), '42' );
      endif;

      $posts[] = array(
        'post_id'   => get_the_id(),
        'permalink' => get_permalink(),
        'datetime'  => get_the_time( 'c' ),
        'text_time' => get_the_time('l').'na, '.get_the_time( 'j.n.Y' ),
        'time'      => get_the_time( 'j.n.Y' ),
        'title'     => get_the_title(),
        'thumb_url' => esc_url( wp_get_attachment_image_src( get_post_thumbnail_id(), 'blog-scroller-bg' )[0] ),
        'excerpt'   => $excerpt,
        'likes'     => dude_get_post_likes( get_the_id() ),
        'class'     => implode( ' ', get_post_class( $class ) ),
        'author'    => array(
          'avatar'    => $author_avatar,
          'name'      => get_the_author_meta( 'first_name' ).' '.get_the_author_meta( 'last_name' )
        )
      );

	  endwhile;
  else:
    return false;
	endif; wp_reset_postdata();

	return $posts;
}
