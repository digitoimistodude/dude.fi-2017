<?php if( !empty( $part['video'] ) ):
  $video = $part['video']; ?>
  <div class="block block-video">
    <div class="container browser">
      <div class="browser-bar"></div>
      <video autoplay loop preload>
        <source src="<?php echo get_theme_file_uri( "videos/{$video}.mp4" ) ?>" type="video/mp4" />
        <source src="<?php echo get_theme_file_uri( "videos/{$video}.webm" ) ?>" type="video/webm" />
        <source src="<?php echo get_theme_file_uri( "videos/{$video}.ogv" ) ?>" type="video/ogv" />
      </video>
    </div>
  </div><!-- .block -->
<?php endif; ?>
