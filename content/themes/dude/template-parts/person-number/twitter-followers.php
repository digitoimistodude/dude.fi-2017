<?php if( !empty( $number['label'] ) && !empty( $number['username'] ) ):

  $twitter = dude_twitter_feed()->get_user_info( $number['username'] );
  if( !empty( $twitter ) ):
    $unixtime = strtotime( $twitter->status->created_at ); ?>
    <div class="number">
      <span class="value"><?php echo $twitter->followers_count ?></span>
      <span class="label"><?php echo $number['label'] ?></span>
      <span class="time">
        <?php echo file_get_contents( get_theme_file_path('svg/twitter.svg') ); _e( 'Uusin tweetti', 'dude' ); ?>
        <span data-time="<?php echo get_date_from_gmt( date( 'Y-m-d H:i:s', $unixtime ), 'Y-m-d H:i:s' ) ?>"><?php echo date_i18n( 'j.n.Y H:i:s', $unixtime ) ?></span>
      </span>
    </div>
  <?php endif;
endif; ?>
