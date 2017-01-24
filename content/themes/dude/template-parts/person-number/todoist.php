<?php if( !empty( $number['label'] ) && !empty( $number['username'] ) ):
  require get_theme_file_path( 'inc/api-todoist.php' );
  $todoist = dude_todoist_feed()->get_completed( $number['username'] );

  if( !empty( $todoist ) ):
    $unixtime = strtotime( $todoist['last_completed'] ); ?>
    <div class="number">
      <span class="value"><?php echo $todoist['count'] ?></span>
      <span class="label"><?php echo $number['label'] ?></span>
      <span class="time">
        <?php echo file_get_contents( get_theme_file_path('svg/todoist.svg') ); _e( 'Viimeksi suoritettu', 'dude' ); ?>
        <span data-time="<?php echo get_date_from_gmt( date( 'Y-m-d H:i:s', $unixtime ), 'Y-m-d H:i:s' ) ?>"><?php echo date_i18n( 'j.n.Y H:i:s', $unixtime ) ?></span>
      </span>
    </div>
  <?php endif;
endif; ?>
