<?php

$permalink_to_blank = false;

$permalink = get_post_meta( get_the_id(), '_link', true );
$permalink_to_blank = get_post_meta( get_the_id(), '_link_to_blank', true );
$time = get_post_meta( get_the_id(), '_time', true );

$repo_activity = null;
$time = null;

$contribution_type = get_post_meta( get_the_id(), '_contribution_type', true );
if( !empty( $contribution_type ) ) {
  if( in_array( $contribution_type, array( 'plugin', 'theme', 'devtool' ) ) ) {
    $github_repo_owner = get_post_meta( get_the_id(), '_github_repo_owner', true );
    $github_repo = get_post_meta( get_the_id(), '_github_repo', true );

    $permalink = 'https://github.com/'.$github_repo_owner.'/'.$github_repo;
    $permalink_to_blank = true;

    $repo_activity = dude_github_feed()->get_repository_details( $github_repo_owner, $github_repo );
    if( !empty( $repo_activity['pushed_at'] ) ) {
      $time = $repo_activity['pushed_at'];
    } else {
      $time = 'overdue';
    }
  }

  $contribution_types = array(
    'plugin'        => __( 'WordPress -lisäosa', 'dude' ),
    'theme'         => __( 'WordPress -teema', 'dude' ),
    'devtool'       => __( 'Työkalu', 'dude' ),
    'community'     => __( 'Yhteisö', 'dude' ),
    'presentation'  => __( 'Esitelmä', 'dude' ),
  );
} ?>

<div class="col col-<?php echo $contribution_type ?>">
  <h3>
    <?php if( !empty( $permalink ) ): ?>
      <a href="<?php echo $permalink ?>" <?php if( $permalink_to_blank ): ?>target="_blank"<?php endif; ?>><?php the_title() ?></a>
    <?php else:
      the_title();
    endif; ?>
  </h3>
  <?php if( !empty( $contribution_type ) ): ?>
    <h4><?php echo $contribution_types[ $contribution_type ] ?></h4>
  <?php endif;

  the_content(); ?>
  <div class="contribution-details">
    <?php if( isset( $repo_activity ) && !empty( $repo_activity['stargazers_count'] ) ): ?>
      <div class="col col-stargazers">
        <p><?php echo file_get_contents( get_theme_file_path('svg/github-star.svg') ); ?> <?php echo $repo_activity['stargazers_count'] ?> <?php _e( 'tähteä', 'dude' ) ?></p>
      </div>
    <?php endif;

    if( !empty( $time ) ): ?>
      <div class="col col-timeago">
        <p>
          <?php if( $time != 'overdue' ): ?>
            <span class="timeago" data-date="<?php echo date( 'Y-m-d H:i:s', strtotime( $time ) ) ?>"><?php echo date_i18n( 'j.n.Y', strtotime( $time ) ); ?></span>
          <?php else:
            _e( 'Yli kolme kuukautta sitten', 'dude' );
          endif; ?>
        </p>
      </div>
    <?php endif; ?>
  </div>
</div>
