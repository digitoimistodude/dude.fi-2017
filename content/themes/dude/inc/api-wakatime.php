<?php

if( !defined( 'ABSPATH' )  )
	exit();

Class Dude_WakaTime_Feed {
  private static $_instance = null;

  /**
   * Construct everything and begin the magic!
   *
   * @since   0.1.0
   * @version 0.1.0
   */
  public function __construct() {
  } // end function __construct

  /**
   *  Prevent cloning
   *
   *  @since   0.1.0
   *  @version 0.1.0
   */
  public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'dude' ) );
	} // end function __clone

  /**
   *  Prevent unserializing instances of this class
   *
   *  @since   0.1.0
   *  @version 0.1.0
   */
  public function __wakeup() {
    _doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'dude' ) );
  } // end function __wakeup

  /**
   *  Ensure that only one instance of this class is loaded and can be loaded
   *
   *  @since   0.1.0
   *  @version 0.1.0
	 *  @return  Main instance
   */
  public static function instance() {
    if( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  } // end function instance

	public function get_best_day( $username = '' ) {
		if( empty( $username ) )
			return;

		$transient_name = apply_filters( 'dude-wakatime/user_stats_transient', 'dude-wakatime-stats-'.$username, $username );
		$stats = get_transient( $transient_name );
	  if( !empty( $stats ) || false != $stats )
	    return $stats;

    $parameters = array(
			'api_key'  => apply_filters( 'dude-wakatime/token/user='.$username, '', $username )
		);

		$response = self::_call_api( $username.'/stats/last_year', $parameters );
		if( $response === FALSE )
			return;

		$response = apply_filters( 'dude-wakatime/user_stats', json_decode( $response, true ) );
		$response = $response['data']['best_day'];

		set_transient( $transient_name, $response, apply_filters( 'dude-wakatime/user_stats_lifetime', '600' ) );
		return $response;
	} // end function get_best_day

	private function _call_api( $endpoint = '', $parameters ) {
		if( empty( $endpoint ) )
			return false;

    $parameters = http_build_query( $parameters );
    $response = wp_remote_get( 'https://wakatime.com/api/v1/users/'.$endpoint.'/?'.$parameters );

		if( $response['response']['code'] !== 200 ) {
			self::_write_log( 'response status code not 200 OK, endpoint: '.$url );
			return false;
		}

		return $response['body'];
	} // end function _call_api

	private function _write_log ( $log )  {
    if( true === WP_DEBUG ) {
      if( is_array( $log ) || is_object( $log ) ) {
        error_log( print_r( $log, true ) );
      } else {
        error_log( $log );
      }
    }
  } // end _write_log
} // end class Dude_WakaTime_Feed

function dude_wakatime_feed() {
  return new Dude_WakaTime_Feed();
} // end function dude_wakatime_feed
