<?php
/**
 * Dude functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package dude
 */

/**
 * The current version of the theme.
 */
define( 'AIR_VERSION', '1.5.5' );

/**
 * Define SendGrid credentials
 */
define('SENDGRID_API_KEY', getenv('SENDGRID_API_KEY'));
define('SENDGRID_STATS_CATEGORIES', 'dude');

/**
 * Disable emojicons introduced with WP 4.2
 *
 * @link http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 */
function dude_disable_wp_emojicons() {

  // All actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  add_filter( 'emoji_svg_url', '__return_false' );

  add_filter( 'tiny_mce_plugins', 'dude_disable_emojicons_tinymce' );

  // Disable classic smilies
  add_filter( 'option_use_smilies', '__return_false' );
}
add_action( 'init', 'dude_disable_wp_emojicons' );

// Disable TinyMCE emojicons
function dude_disable_emojicons_tinymce( $plugins ) {
  if( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

// Add image sizes
add_image_size( 'blog-scroller-bg', '1500', '500', true );

/**
 * Remove useless YARPP stylesheets
 *
 * @link https://wordpress.org/support/topic/prevent-loading-relatedcss-and-widgetcss
 */
function dude_deregister_plugin_assets_header() {
  wp_dequeue_style( 'yarppWidgetCss' );
  wp_deregister_style( 'yarppRelatedCss' );
}
add_action( 'wp_print_styles', 'dude_deregister_plugin_assets_header' );

function dude_deregister_plugin_assets_footer() {
  wp_dequeue_style( 'yarppRelatedCss' );
}
add_action( 'wp_footer', 'dude_deregister_plugin_assets_footer' );

/**
 * Wrap every image with a div in a post with certain pattern
 */
function wrapimageswithdiv( $content ) {

   // A regular expression of what to look for.
   $pattern = '/(<img .*?class="(.*?photoblog.*?)"([^>]*)>)/i';
   // What to replace it with. $1 refers to the content in the first 'capture group', in parentheses above
   $replacement = '<div class="entry-photo">$1</div>';

   // Run preg_replace() on the $content
   $content = preg_replace( $pattern, $replacement, $content );

   // Return the processed content
   return $content;
}
add_filter( 'the_content', 'wrapimageswithdiv' );

/**
 * Allow Gravity Forms to hide labels to add placeholders
 */
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

/**
 * Enable theme support for essential features
 */
load_theme_textdomain( 'dude', get_template_directory().'/languages' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
setlocale( LC_ALL, 'fi_FI.utf8' );

/**
* Hide WP updates nag
*/
add_action( 'admin_menu', 'dude_wphidenag' );
function dude_wphidenag() {
	remove_action( 'admin_notices', 'update_nag', 3 );
}

/**
 * Editable navigation menus.
 */
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'dude' ),
) );

/**
 * Custom navigation walker
 */
require get_template_directory() . '/nav.php';

/**
 *  Require include files
 */
require get_template_directory().'/inc/cpt/reference.php';
require get_template_directory().'/inc/cpt/contribution.php';
require get_template_directory().'/inc/cpt/service.php';
require get_template_directory().'/inc/cpt/person.php';
require get_template_directory().'/inc/metabox/reference.php';
require get_template_directory().'/inc/metabox/service.php';
require get_template_directory().'/inc/metabox/post.php';
require get_template_directory().'/inc/metabox/page.php';
require get_template_directory().'/inc/metabox/contribution.php';
require get_template_directory().'/inc/metabox/wplf-form.php';
require get_template_directory().'/inc/metabox/person.php';
require get_template_directory().'/inc/metabox/tax-service.php';
require get_template_directory().'/inc/metabox/front-page.php';
require get_template_directory().'/inc/metabox/template-dude.php';
require get_template_directory().'/inc/metabox/template-contributions.php';
require get_template_directory().'/inc/metabox/archive-reference.php';
require get_template_directory().'/inc/options-page.php';
require get_template_directory().'/inc/functions.php';
require get_template_directory().'/inc/hooks.php';
require get_template_directory().'/inc/rest-blog-scroller.php';
require get_template_directory().'/inc/rest-likes.php';
require get_template_directory().'/inc/comments.php';

/**
 * Remove WordPress Admin Bar
 *
 * @link http://davidwalsh.name/remove-wordpress-admin-bar-css
 */
add_action( 'get_header', 'dude_remove_admin_login_header' );
function dude_remove_admin_login_header() {
  remove_action( 'wp_head', '_admin_bar_bump_cb' );
}

if( getenv( 'WP_ENV' ) === 'development' ) {
	add_action( 'wp_head', function() { ?>
		<style>
			#wpadminbar {
				top: auto;
				bottom: 0;
			}

			#wpadminbar.nojs li:hover > .ab-sub-wrapper,
			#wpadminbar li.hover > .ab-sub-wrapper {
				bottom: 32px;
			}
		</style>
	<?php } );
} else {
	show_admin_bar( false );
}

/**
 * Custom uploads folder media/ instead of default content/uploads/.
 * Comment these out if you want to set up media library folder in wp-admin.
 */
update_option( 'upload_path', untrailingslashit( str_replace( 'wp', 'media', ABSPATH ) ) );
update_option( 'upload_url_path', untrailingslashit( str_replace( 'wp', 'media', get_site_url() ) ) );
define( 'uploads', ''.'media' );
add_filter( 'option_uploads_use_yearmonth_folders', '__return_false', 100 );

if( !function_exists( 'dude_entry_footer' ) ):
  /**
   * Prints HTML with meta information for the categories, tags and comments.
   */
  function dude_entry_footer() {
  	// Hide category and tag text for pages.
  	if( 'post' === get_post_type() ) {

  		/* translators: used between list items, there is a space after the comma */
  		$categories_list = get_the_category_list();
  		if( $categories_list ) {
  			printf( $categories_list ); // WPCS: XSS OK.
  		}

  		/* translators: used between list items, there is a space after the comma */
  		$tags_list = get_the_tag_list();
  		if( $tags_list ) {
  			echo get_the_tag_list('<ul class="tags"><li>', '</li><li>', '</li></ul>');
  		}
  	}

  	if( !is_single() && !post_password_required() && ( comments_open() || get_comments_number() ) ) {
  		echo '<span class="comments-link">';
  		comments_popup_link( sprintf( wp_kses( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'dude' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
  		echo '</span>';
  	}

  	edit_post_link(
  		sprintf(
  			/* translators: %s: Name of current post */
  			esc_html__( 'Edit %s', 'dude' ),
  			the_title( '<span class="screen-reader-text">"', '"</span>', false )
  		),
  		'<p class="edit-link">',
  		'</p>'
  	);
  }
endif;

/**
 * Enqueue scripts and styles.
 */
function dude_scripts() {
  wp_enqueue_style( 'layout', get_theme_file_uri( 'css/global.css' ), array(), filemtime( get_theme_file_path( 'css/global.css' ) ) );

  wp_enqueue_script( 'jquery-core' );
  wp_enqueue_script( 'scripts', get_theme_file_uri( 'js/all.js' ), array(), filemtime( get_theme_file_path( 'js/all.js' ) ), true );

	if( is_page_template( 'template-contributions.php' ) ) {
		wp_enqueue_script( 'contributions', get_theme_file_uri( 'js/contributions.js' ), array(), filemtime( get_theme_file_path( 'js/contributions.js' ) ) );
  }

  if( is_page_template( 'template-contact.php' ) ) {
    wp_enqueue_script( 'wplf-form-js' );
    wp_localize_script( 'wplf-form-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

    wp_enqueue_script( 'fitvids', get_theme_file_uri( 'js/src/fitvids.min.js' ), array(), filemtime( get_theme_file_path( 'js/src/fitvids.min.js' ) ), true );
    wp_enqueue_script( 'interactive-form', get_theme_file_uri( 'js/src/interactive-form.js' ), array(), filemtime( get_theme_file_path( 'js/interactive-form.js' ) ), true );
    wp_localize_script( 'interactive-form', 'dudeinteractiveform', array(
      'sayatmemessage'  => get_post_meta( '2048', '_sayatme_message', true ),
      'sayatmeemail'    => get_post_meta( '2048', '_sayatme_email', true ),
      'sayatmephone'    => get_post_meta( '2048', '_sayatme_phone', true ),
    ) );
  }

  if( is_singular( array( 'person' ) ) ) {
    wp_enqueue_script( 'person', get_theme_file_uri( 'js/person.js' ), array(), filemtime( get_theme_file_path( 'js/person.js' ) ), true );
  }

  if( is_singular( array( 'post' ) ) ) {
    wp_enqueue_script( 'person', get_theme_file_uri( 'js/like.js' ), array(), filemtime( get_theme_file_path( 'js/like.js' ) ), true );
    wp_localize_script( 'person', 'dudelike', array(
      'nonce'   => wp_create_nonce( 'wp_rest' )
    ) );
  }

  if( is_home() || ( is_archive() && !is_post_type_archive( 'reference' ) ) ) {
    wp_enqueue_script( 'archive', get_theme_file_uri( 'js/archive.js' ), array(), filemtime( get_theme_file_path( 'js/archive.js' ) ), true );
  }

  if( is_404() ) {
    wp_enqueue_script( 'grained', get_theme_file_uri( 'js/src/grained.min.js' ), array(), filemtime( get_theme_file_path( 'js/src/grained.min.js' ) ) );
  }
}
add_action( 'wp_enqueue_scripts', 'dude_scripts' );
