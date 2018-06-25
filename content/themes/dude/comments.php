<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package dude
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if( post_password_required() ) {
	return;
}
?>

<div class="block block-comments">

  <div class="container" id="kommentoi">

  	<div id="comments" class="comments-area">

  		<?php if( have_comments() ):
        // Are there comments to navigate through?
        if( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ): ?>
    			<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
    				<h2 class="screen-reader-text"><?php esc_html_e( 'Kommenttien navigaatio', 'dude' ); ?></h2>
    				<div class="nav-links">

    					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Vanhemmat kommentit', 'dude' ) ); ?></div>
    					<div class="nav-next"><?php next_comments_link( esc_html__( 'Uudemmat kommentit', 'dude' ) ); ?></div>

    				</div><!-- .nav-links -->
    			</nav><!-- #comment-nav-above -->
  			<?php endif; ?>

  			<ol class="comment-list">
  				<?php wp_list_comments( array(
  						'style'       => 'ol',
  						'short_ping'  => true,
              'callback'    => 'dude_comments',
  					) );
  				?>
  			</ol><!-- .comment-list -->

  			<?php // Are there comments to navigate through?
        if( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ): ?>
    			<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
            <h2 class="screen-reader-text"><?php esc_html_e( 'Kommenttien navigaatio', 'dude' ); ?></h2>
    				<div class="nav-links">

    					<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Vanhemmat kommentit', 'dude' ) ); ?></div>
    					<div class="nav-next"><?php next_comments_link( esc_html__( 'Uudemmat kommentit', 'dude' ) ); ?></div>

    				</div><!-- .nav-links -->
    			</nav><!-- #comment-nav-below -->
  			<?php endif;
  		endif;


  		// If comments are closed and there are comments, let's leave a little note, shall we?
  		if( !comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ): ?>
  			<p class="no-comments"><?php esc_html_e( 'Kommentointi on suljettu.', 'dude' ); ?></p>
  		<?php endif;

      $commenter = wp_get_current_commenter();
      $req = get_option( 'require_name_email' );
      $aria_req = ( $req ? " aria-required='true'" : '' );

      $args = array(
        'title_reply'          => '<a name="kommentoi" id="kommentoi" aria-hidden="true"></a>'.__( 'Kommentoi', 'dude' ).' ',
        'label_submit'         => __( 'Anna palaa!', 'dude' ),
        'comment_notes_before' => ''.__( '', 'dude' ).'',
        'comment_field'        => '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">'._x( 'Comment', 'noun' ).'</label><textarea id="comment" placeholder="'.__( 'Kirjoita kommenttisi tähän. Kenttä laajenee automaattisesti.', 'dude' ).'" name="comment" cols="45" rows="2" aria-required="true"></textarea></p>',
        'fields'               => apply_filters( 'comment_form_default_fields', array(
          'author'  => '<p class="comment-form-author">'.'<label class="screen-reader-text" for="author">'.__( 'Nimesi', 'dude' ).'</label> '.( $req ? '<span class="required screen-reader-text">Vaadittu kenttä</span>' : '' ).'<input id="author" name="author" placeholder="'.__( 'Nimesi', 'dude' ).'" type="text" value="'.esc_attr( $commenter['comment_author'] ).'" size="30"'.$aria_req.' /></p>',
          'email'   => '<p class="comment-form-email"><label class="screen-reader-text" for="email">'.__( 'Sähköpostiosoite (vaaditaan, mutta ei julkaista)', 'dude' ).'</label> '.( $req ? '<span class="required screen-reader-text">Vaadittu kenttä</span>' : '' ).'<input id="email" name="email" placeholder="'.__( 'Sähköpostiosoite (vaaditaan, mutta ei julkaista)', 'dude' ).'" type="text" value="'.esc_attr(  $commenter['comment_author_email'] ).'" size="30"'.$aria_req.' /></p>',
          'url'     => '<p class="comment-form-url"><label class="screen-reader-text" for="url">'.__( 'Verkkosivusi (jos haluat)', 'dude' ).'</label>'.'<input id="url" name="url" placeholder="'.__( 'http://', 'dude' ).'" type="text" value="'.esc_attr( $commenter['comment_author_url'] ).'" size="30" /></p>',
        ) )
      );

      comment_form( $args ); ?>

  	</div><!-- #comments -->

  </div><!-- .container -->

</div><!-- .block -->
