<?php

/**
 * Social media plugin keys
 */
// Twitter
add_filter( 'dude-twitter-feed/oauth_consumer_key', function() {
	return getenv( 'TWITTER_CONSUMER_KEY' );
} );

add_filter( 'dude-twitter-feed/oauth_consumer_secret', function() {
	return getenv( 'TWITTER_CONSUMER_SECRET' );
} );

add_filter( 'dude-twitter-feed/oauth_access_token', function() {
	return getenv( 'TWITTER_ACCESS_TOKEN' );
} );

add_filter( 'dude-twitter-feed/oauth_access_token_secret', function() {
	return getenv( 'TWITTER_ACCESS_SECRET' );
} );

// Insta Timi
add_filter( 'dude-insta-feed/access_token/user=3038518606', function() {
	return getenv( 'INSTA_TIMI' );
} );

// Insta Juha
add_filter( 'dude-insta-feed/access_token/user=32225465', function() {
	return getenv( 'INSTA_JUHA' );
} );

// Insta Kristian
add_filter( 'dude-insta-feed/access_token/user=1824383535', function() {
	return getenv( 'INSTA_KRISSE' );
} );

// Insta Roni
add_filter( 'dude-insta-feed/access_token/user=30821744', function() {
	return getenv( 'INSTA_RONI' );
} );

// Insta settings
add_filter( 'dude-insta-feed/user_images_parameters', function( $parameters ) {
  $parameters['count'] = '1';
  return $parameters;
} );

// Todoist Roni
add_filter( 'dude-todoist/token/user=roni', function() {
  return getenv( 'TODOIST_RONI' );
} );

// Untappd Roni
add_filter( 'dude-untappd/client_id/user=rolle', function() {
  return getenv( 'UNTAPPD_ID_RONI' );
} );
add_filter( 'dude-untappd/client_secret/user=rolle', function() {
  return getenv( 'UNTAPPD_SECRET_RONI' );
} );

// Wakatime Roni
add_filter( 'dude-wakatime/token/user=rolle', function() {
  return getenv( 'WAKATIME_RONI' );
} );

// Todoist Timi
add_filter( 'dude-todoist/token/user=timi', function() {
  return getenv( 'TODOIST_TIMI' );
} );

// Wakatime Timi
add_filter( 'dude-wakatime/token/user=sippis', function() {
  return getenv( 'WAKATIME_TIMI' );
} );

/**
 *  Modify default admin menu order
 */
function dude_menu_order( $menu_order ) {
  if( !$menu_order )
		return true;

  return array(
    'index.php',
    'separator1',
    'edit.php',
		'edit.php?post_type=page',
		'edit.php?post_type=reference',
		'edit.php?post_type=contribution',
		'edit.php?post_type=service',
		'edit.php?post_type=person',
    'edit.php?post_type=wplf-form',
    'upload.php',
    'edit-comments.php',
    'separator2',
		'plugins.php',
		'themes.php',
    'users.php',
    'tools.php',
    'options-general.php',
    'separator-last',
  );
} // end function dude_menu_order
add_filter( 'custom_menu_order', 'dude_menu_order' );
add_filter( 'menu_order', 'dude_menu_order' );

/**
 * Append stuff to menu.
 */
function dude_add_cta_button( $items, $args ) {
	if ( 'primary' === $args->theme_location ) {
  	$items .= '<li class="menu-item menu-code menu-item-type-post_type menu-item-object-page"><a href="' . get_page_link(1972) . '"><span class="screen-reader-text">'.__( 'Koodit', 'dude' ).'</span>'.file_get_contents( esc_url( get_stylesheet_directory().'/svg/code-2.svg' ) ).'</a></li>';
  }

 return $items;
} // end function dude_add_cta_button
add_filter( 'wp_nav_menu_items', 'dude_add_cta_button', 10, 2 );

/**
 * Remove slug from service single permalinks
 */
function dude_remove_slug( $post_link, $post, $leavename ) {
  if( 'service' != $post->post_type || 'publish' != $post->post_status ) {
    return $post_link;
  }

  $post_link = str_replace( '/'.$post->post_type.'/', '/', $post_link );

  return $post_link;
}
add_filter( 'post_type_link', 'dude_remove_slug', 10, 3 );

/**
 * Parse request and set things for service single without permalinks
 */
function dude_parse_request_for_service_slug( $query ) {
  if( !$query->is_main_query() || 2 != count( $query->query ) || !isset( $query->query['page'] ) ) {
    return;
  }

  if( !empty( $query->query['name'] ) ) {
    $query->set( 'post_type', array( 'post', 'service', 'page' ) );
  }
}
add_action( 'pre_get_posts', 'dude_parse_request_for_service_slug' );

/**
 * reference archive posts_per_page
 */
function dude_pre_get_posts_for_reference( $query ) {
  if( $query->is_main_query() && $query->is_post_type_archive( 'reference' ) ) {
    $query->set( 'posts_per_page', 100 );
  }
}
add_action( 'pre_get_posts', 'dude_pre_get_posts_for_reference' );

/**
 * Remove archive title prefixes from references
 */
function dude_use_archive_prefix( $output, $object ) {
  if( 'reference' === $object->name )
    return false;

  return true;
}
add_filter( 'the_seo_framework_use_archive_title_prefix', 'dude_use_archive_prefix', 10, 2 );

/**
 * Set better description on reference archive
 */
function dude_meta_output( $description ) {
  if( is_post_type_archive( 'reference' ) ) {
    $description = get_post_meta( get_option( 'page_for_reference' ), '_genesis_description', true );

    if( empty( $description ) ) {
      $description = get_post_field( 'post_content', get_option( 'page_for_reference' ) );
    }
  }

  if( is_singular( 'reference' ) ) {
    $description = get_post_meta( get_the_id(), '_genesis_description', true );

    if( empty( $description ) ) {
      $description = get_post_meta( get_option( 'page_for_reference' ), '_genesis_description', true );
    }
  }

  if( is_home() || ( is_archive() && !is_post_type_archive( 'reference' ) ) ) {
    $description = get_post_meta( get_option( 'page_for_posts' ), '_genesis_description', true );
  }

  return esc_html( $description );
}
add_filter( 'the_seo_framework_description_output', 'dude_meta_output' );
add_filter( 'the_seo_framework_ogdescription_output', 'dude_meta_output' );
add_filter( 'the_seo_framework_twitterdescription_output', 'dude_meta_output' );

/**
 * Enqueue blog scroller js if blog scroller partial is used
 */
function dude_enqueue_blog_scroller_js( $slug, $name ) {
  wp_enqueue_script( 'blog-wheel', get_theme_file_uri( 'js/blog-scroller.js' ), array(), filemtime( get_theme_file_path( 'js/blog-scroller.js' ) ), true );
}
add_action( 'get_template_part_template-parts/blog-scroller', 'dude_enqueue_blog_scroller_js', 10, 2 );

/**
 * Add likes and revisions columns to posts listing
 */
function dude_posts_columns( $columns ) {
  return array_merge( $columns,
    array(
      'likes'     => __( 'Tykkäyksiä', 'dude' ),
      'revisions' => __( 'Versioita', 'dude' )
      )
  );
}
add_filter( 'manage_posts_columns' , 'dude_posts_columns' );

function dude_posts_custom_columns( $column, $post_id ) {
  switch ( $column ) {
    case 'likes':
      echo get_post_meta( $post_id, '_post_like_count', true );
      break;

    case 'revisions':
      echo count( wp_get_post_revisions( $post_id ) );
      break;
  }
}
add_action('manage_posts_custom_column' , 'dude_posts_custom_columns', 10, 2 );

/**
 * Prevent single attachment page
 */
function dude_redirect_attachment_page() {
	if( is_attachment() ) {
		global $post;

    if( $post && $post->post_parent ) {
			wp_redirect( esc_url( get_permalink( $post->post_parent ) ), 301 );
			exit;
		} else {
			wp_redirect( esc_url( home_url( '/' ) ), 301 );
			exit;
		}
	}
}
add_action( 'template_redirect', 'dude_redirect_attachment_page' );

/**
 * Add GET parameters to youtube iframe if we are in contact page
 */
function dude_embed_handler_oembed_youtube( $html, $url, $attr, $post_id ) {
  if( is_page_template( 'template-contact.php' ) )
    return $html;

  if( strpos( $url, 'youtu.be' )!== false ) {
    $doc = new DOMDocument();
    $doc->loadHTML( $html );
    $tags = $doc->getElementsByTagName( 'iframe' );

    if( count( $tags ) > 0 ) {
      $tag = $tags->item(0);
      $src = $tag->getAttribute( 'src' );
      $tag->setAttribute( 'src', $src.'&autoplay=1&rel=0&controls=0&showinfo=0' );
      return $doc->saveHTML( $tag );
    }
  }

  return $html;
}
add_filter( 'embed_oembed_html', 'dude_embed_handler_oembed_youtube', 10, 4 );

/**
 * Add needed resoure hints
 */
function dude_resource_hints( $hints, $relation_type ) {
  if( 'dns-prefetch' === $relation_type && is_page_template( 'template-contact.php' ) ) {
    $hints[] = '//youtube.com';
    $hints[] = '//platform.twitter.com';
  } elseif( 'preconnect' === $relation_type ) {
    $hints[] = '//coffter.dude.fi';
    $hints[] = '//dude.fi';
  }

  return $hints;
}
add_filter( 'wp_resource_hints', 'dude_resource_hints', 10, 2 );

/**
 * Prevent Carbon Fields from saving empty rows on spesific meta keys
 */
function dude_no_empty_post_meta_rows( $meta_id, $object_id, $meta_key, $meta_value ) {
  if( !empty( $meta_value ) )
    return;

  $fields_not_to_save = array(
    // Single contribution
    '_contribution_type'  => true,

    // Single reference fields
    '_pool_upsell'        => true,
    '_show_general'       => true,

    // Single person and reference fields
    '_quote'              => true,
    '_quote_image'        => true,
  );

  if( isset( $fields_not_to_save[ $meta_key ] ) )
    delete_post_meta( $object_id, $meta_key, $meta_value );
}
add_filter( 'updated_post_meta', 'dude_no_empty_post_meta_rows', 50, 4 );
add_filter( 'added_post_meta', 'dude_no_empty_post_meta_rows', 50, 4 );

/**
 * Part of wplf no jos submission fallback solution
 */
function dude_wplf_nojs_submit() {
  if( isset( $_POST['dude-nojs'] ) ) {
    wplf_ajax_submit_handler( true );
    $_POST['_wplf_success'] = true;
  }
}
add_action( 'init', 'dude_wplf_nojs_submit' );

/**
 * If user hits empty paginated blog, redirect to blog base
 */
function dude_redirect_empty_blog_page() {
  global $wp_query;

  if( is_main_query() && strpos( $_SERVER['REQUEST_URI'], 'blogi' ) !== false && !$wp_query->have_posts() ) {
    wp_safe_redirect( get_permalink( get_option( 'page_for_posts' ) ), 302 );
    exit();
  }
}
add_action( 'wp', 'dude_redirect_empty_blog_page' );

// Disable srcset
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );

// Remove those pesky SEO indicators in post lists.
add_filter( 'the_seo_framework_indicator', '__return_false' );
add_filter( 'the_seo_framework_show_seo_column', '__return_false' );

// Don't do wpautop for wplf
remove_filter( 'wplf_form', 'wpautop' );
remove_filter( 'wplf_form', 'wptexturize' );

// Fix wplf success message video.
function dude_wplf_success_the_content( $content ) {
	return apply_filters( 'the_content', $content );
}
add_filter( 'wplf_success_message', 'dude_wplf_success_the_content' );

add_filter('wpseo_opengraph_image', 'dude_wpseo_default_og_image');
function dude_wpseo_default_og_image($image) {
  if ( empty( $image ) ) {
    $image = get_template_file_uri( 'images/dude-default.jpg' );
  }

  return $image;
}
