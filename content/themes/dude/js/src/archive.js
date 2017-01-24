( function( $ ) {
  $(document).ready(function() {
    var paged = 2;
    var blog = new Vue({
      el: '.container-blog-main',
      data: {
        posts: []
      }
    });

    $('.nav-previous').on('click', function(e) {
      e.preventDefault();

      if( $('body').hasClass('archive') ) {
        if( $('body').hasClass('date') ) {
          window.location = $(this).find('a').attr('href');
          return;
        }

        var archice_class = $('body').attr('class').split(' ').pop();
        var archive_type = archice_class.substr( 0, archice_class.indexOf( '-' ) );
        var archive_id = archice_class.substr( archice_class.indexOf( '-' ) + 1 );
        var endpoint_uri = '/wp-json/dude/v1/posts/'+paged+'?archive='+archive_type+'&archive_id='+archive_id;
      }  else {
        var endpoint_uri = '/wp-json/dude/v1/posts/'+paged;
      }

      jQuery.ajax({
        method: 'GET',
        url: endpoint_uri,
      }).done( function( response ) {
        if( response.length !== 0 && response !== false ) {
          jQuery.each( response, function() {
            var self = this;
            blog.posts.push(this);

            check_user_likes( 'article.post' );
          } );

          if( response.length < 8 ) {
            jQuery('.nav-links').hide();
          }

          paged = paged+1;
        } else if( response == false ) {
          jQuery('.nav-links').hide();
        }
      });
    });
  });
} )( jQuery );
