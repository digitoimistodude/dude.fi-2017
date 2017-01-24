<?php if( !empty( $number['label'] ) && !empty( $number['username'] ) ): ?>
  <div class="number timefrom">
    <span class="value" data-time="<?php echo get_date_from_gmt( date( 'Y-m-d H:i:s', strtotime( $number['username'] ) ), 'Y-m-d H:i:s' ) ?>"><?php echo $number['username'] ?></span>
    <span class="label"><span></span><?php echo $number['label'] ?></span>
  </div>
<?php endif; ?>
