<?php if( !empty( $number['label'] ) && !empty( $number['username'] ) ):

  require get_theme_file_path( 'inc/api-wakatime.php' );
  $wakatime = dude_wakatime_feed()->get_best_day( $number['username'] );

  if( !empty( $wakatime ) ):
    $unixtime = strtotime( $wakatime['date'] );
    $hours = gmdate('H.s', $wakatime['total_seconds']);
    $hours = ceil( $hours ); ?>
    <div class="number">
      <span class="value"><?php echo $hours ?></span>
      <span class="label"><?php echo $number['label'] ?></span>
      <span class="time">
        <?php echo file_get_contents( get_theme_file_path('svg/wakatime.svg') ); _e( 'Oli', 'dude' ); ?>
        <span data-time="<?php echo get_date_from_gmt( date( 'Y-m-d H:i:s', $unixtime ), 'Y-m-d H:i:s' ) ?>"><?php echo date_i18n( 'j.n.Y H:i:s', $unixtime ) ?></span>
      </span>
    </div>
  <?php endif;
endif; ?>
