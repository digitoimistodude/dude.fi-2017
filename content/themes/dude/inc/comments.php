<?php
/**
 * Custom comments
 */
function dude_comments( $comment, $args, $depth ) {
$GLOBALS['comment'] = $comment; ?>

  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>">
        <?php echo get_avatar( $comment, $size = '62' ); ?>
        <h4 class="comment-author"><?php printf(__('<a href="#">%s</h4>'), get_comment_author_link()) ?></a>

      <?php if ( 0 === $comment->comment_approved ) : ?>
        <p><em>Kommenttisi odottaa ylläpidon hyväksymistä.</em></p>
      <?php endif; ?>

        <p class="comment-time">
          <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
            <?php echo file_get_contents( esc_url( get_stylesheet_directory() . '/svg/link.svg' ) ); ?>
            <time><?php printf(__('%1$s at %2$s'), get_comment_date(), get_comment_time()) ?></time>
          </a>
        </p>

        <?php comment_text() ?>

        <?php
        $args = array(
           'depth' => $depth,
           'max_depth' => $args['max_depth'],
           'reply_text' => file_get_contents( esc_url( get_stylesheet_directory() . '/svg/reply.svg' ) ) . '<span class="reply-text">' . __( 'Vastaa tähän kommenttiin', 'dude' ) . '</span>',
        );

        comment_reply_link( $args ); ?>
        <?php edit_comment_link(__('&mdash; Muokkaa'),'  ','') ?>

    </div>
<?php
}
