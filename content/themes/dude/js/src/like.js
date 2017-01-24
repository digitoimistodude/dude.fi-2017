( function( $ ) {
  $(document).ready(function() {
    $('.likes').on('click', function() {
      var post_id = $(this).data('id');
      var user_likes = JSON.parse( localStorage.getItem( 'dude_liked_posts' ) );

      if( user_likes === null ) {
        user_likes = [];
      }

      if( $.inArray( post_id, user_likes ) > -1 ) {
        $(this).removeClass('liked');
        var endpoint_uri = '/wp-json/dude/v1/post/'+post_id+'/unlike';
        var index = user_likes.indexOf( post_id );
        if( index > -1 ) {
          user_likes.splice( index, 1 );
        }
      } else {
        $(this).addClass('liked');
        user_likes.push( post_id );
        var endpoint_uri = '/wp-json/dude/v1/post/'+post_id+'/like';
      }

      jQuery.ajax({
        method: 'GET',
        beforeSend: function ( xhr ) {
          xhr.setRequestHeader( 'X-WP-Nonce', dudelike.nonce );
        },
        url: endpoint_uri,
      }).done( function( response ) {
        if( response.length !== 0 && response.status === 'success' ) {
          $('.likes span').html( response.count )
        }
      });

      localStorage.setItem( 'dude_liked_posts', JSON.stringify( user_likes ) );
    });
  });
} )( jQuery );
