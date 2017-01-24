<?php if( !empty( $number['label'] ) && !empty( $number['username'] ) ):

  require get_theme_file_path( 'inc/api-untappd.php' );
  $untappd = dude_untappd_feed()->get_user( $number['username'] );

  if( !empty( $untappd ) ):
    $unixtime = strtotime( $untappd['checkins']['items'][0]['created_at'] ); ?>
    <div class="number">
      <span class="value"><?php echo $untappd['stats']['total_beers'] ?></span>
      <span class="label"><?php echo $number['label'] ?></span>
      <span class="time">
        <?php echo file_get_contents( get_theme_file_path('svg/untappd.svg') ); _e( 'Viimeksi korkattu', 'dude' ); ?>
        <span data-time="<?php echo get_date_from_gmt( date( 'Y-m-d H:i:s', $unixtime ), 'Y-m-d H:i:s' ) ?>"><?php echo date_i18n( 'j.n.Y H:i:s', $unixtime ) ?></span>
      </span>
    </div>
  <?php endif;
endif; ?>
