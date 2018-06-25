var blog = new Vue({
  el: '#blog-scroller',
  data: {
    posts: []
  }
});

function load_posts() {
  var paged = jQuery('.blogposts').attr('data-rest-paged');
  var cat = jQuery('.blogposts').attr('data-rest-cat');

  if( typeof cat != 'undefined' && cat.length != 0 ) {
    var endpoint_uri = '/wp-json/dude/v1/posts/'+paged+'?cat='+cat;
  } else {
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

        setTimeout( function() {
          jQuery('.blogposts').slick( 'slickAdd', jQuery('#hiddenpost-'+self.post_id).html() );
          jQuery('#hiddenpost-'+self.post_id).remove();
          check_user_likes( '.blogpost' );
        }, 2 );
      } );

      jQuery('.blogposts').attr('data-rest-paged', parseInt( paged )+1);
    } else if( response == false ) {
      jQuery('.blogposts').slick( 'slickAdd', jQuery('.block-blogposts .last-card-holder').html() );
      jQuery('.block-blogposts .last-card-holder').remove();
    }
  });
}

( function( $ ) {

  // On slick init, set blog area bg
  jQuery('.blogposts').on('init', function(event, slick) {
    var shade = jQuery('.block-blogposts .shade');
    var featured_bg =  jQuery('.blogpost').get( 0 );

    shade.css( 'background-image', 'url(' + jQuery( featured_bg ).attr( 'data-background' ) + ')' );
  });

  // Blog "blockr"
  jQuery('.blogposts').slick({
    dots: false,
    arrows: true,
    infinite: false,
    speed: 100,
    blocksToShow: 3,
    blocksToScroll: 1,
    centerMode: false,
    variableWidth: true,
    draggable: false,
    swipeToblock: true,
    appendArrows: jQuery('.block-blogposts')
  });

  // On blockr change, set bg and maybe load more posts
  jQuery('.blogposts').on('afterChange', function(event, slick, currentblock) {
    var shade = jQuery('.block-blogposts .shade');
    var featured_bg =  jQuery('.blogpost').get( currentblock );

    shade.css( 'background-image', 'url(' + jQuery( featured_bg ).attr( 'data-background' ) + ')' );

    if( currentblock === jQuery('.blogpost').length-12 ) {
      load_posts();
    }
  });

  // On init load more posts
  load_posts();
  check_user_likes( '.blogpost' );

} )( jQuery );
