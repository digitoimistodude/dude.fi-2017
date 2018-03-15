<?php

function dude_get_coffee_drunk() {
  $transient_name = 'dude_coffter_week';
	$data = get_transient( $transient_name );
  if( !empty( $data ) || false != $data )
    return $data;

  $response = wp_remote_get( 'http://coffter.dude.fi/v1/coffee/drunk/week' );
	if( $response['response']['code'] !== 200 )
		return false;

  set_transient( $transient_name, json_decode( $response['body'], true ), 600 );
	return json_decode( $response['body'], true );
}

function dude_get_post_likes( $post_id = null ) {
  if( empty( $post_id ) )
    return '0';

  $likes = get_post_meta( $post_id, '_post_like_count', true );
  if( empty( $likes ) )
    $likes = '0';

  return $likes;
}

function dude_shortcode_mailchimp_form_for_post() {
  ob_start(); ?>

  <!-- Begin MailChimp Signup Form -->
  <style type="text/css">
    #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif;text-align: center;}
  </style>
  <div id="mc_embed_signup">
  <form action="https://dude.us8.list-manage.com/subscribe/post?u=bda4635b58bba8d9716eb90a6&amp;id=efe9db80e6" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
      <div id="mc_embed_signup_scroll">

    <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Sähköpostiosoitteesi" style="padding: 12px 10px; width: 50%; font-size: 16px; line-height: 22.4px; line-height: 1.4rem; margin-bottom: 15px;" required>
      <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
      <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_bda4635b58bba8d9716eb90a6_efe9db80e6" tabindex="-1" value=""></div>
      <div class="clear"><input type="submit" value="Pullopostia? Kyllä kiitos!" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
      </div>
  </form>
  </div>

  <!--End mc_embed_signup-->

  <?php return ob_get_clean();
}
add_shortcode( 'mailchimp_form_for_post', 'dude_shortcode_mailchimp_form_for_post' );
