<?php

if( !defined( 'ABSPATH' )  )
	exit();

Class Dude_Todoist_Feed {
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

	public function get_completed( $username = '' ) {
		if( empty( $username ) )
			return;

		$transient_name = apply_filters( 'dude-todoist/user_completed_transient', 'dude-todoist-completed-'.$username, $username );
		$completed = get_transient( $transient_name );
	  if( !empty( $completed ) || false != $completed )
	    return $completed;

    $parameters = array(
			'token'          => apply_filters( 'dude-todoist/token/user='.$username, '', $username ),
			'annotate_notes' => false,
      'since'          => date( 'Y-n-01' ).'T00:00',
      'limit'          => 50
		);

		$response = self::_call_api( 'completed/get_all', $parameters );
		if( $response === FALSE )
			return;

		$i = 0;
    $offset = 50;
		$response = apply_filters( 'dude-todoist/user_completed', json_decode( $response, true ) );

		foreach( $response['items'] as $key => $event ) {
			$i++;
		}

    $completed['last_completed'] = $response['items'][0]['completed_date'];

    while( count( $response['items'] ) === 50 ) {
      $parameters['offset'] = $offset;

      $response = self::_call_api( 'completed/get_all', $parameters );
  		if( $response === FALSE )
  			return;

      $response = apply_filters( 'dude-todoist/user_completed', json_decode( $response, true ) );

      foreach( $response['items'] as $key => $event ) {
  			$i++;
  		}

      $offset = $offset+50;
    }

    $completed['count'] = $i;

		set_transient( $transient_name, $completed, apply_filters( 'dude-todoist/user_completed_lifetime', '600' ) );
		return $completed;
	} // end function get_users_activity

	private function _call_api( $endpoint = '', $parameters ) {
		if( empty( $endpoint ) )
			return false;

    $parameters = http_build_query( $parameters );
    $response = wp_remote_get( 'https://todoist.com/API/v7/'.$endpoint.'/?'.$parameters );

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
} // end class Dude_Todoist_Feed

function dude_todoist_feed() {
  return new Dude_Todoist_Feed();
} // end function dude_todoist_feed
