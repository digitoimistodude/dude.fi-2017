/**
 * dude theme JavaScript.
 */

( function( $ ) {

  // Activate submit button when all fields filled out in comments section
  $('#commentform textarea#comment, #commentform input#author, #commentform input#email').on('keyup', function() {
      if( $(this).val() != '' ) {
          $('#commentform input#submit').removeClass('active');
      } else {
          $('#commentform input#submit').removeClass('active');
      }
  });

  $('#commentform textarea#comment, #commentform input#author, #commentform input#email').on('change', function() {
        if( $(this).val() != '' ) {
            $('#commentform input#submit').addClass('active');
        } else {
            $('#commentform input#submit').removeClass('active');
        }
  });

  // Do stuff when scrolling to a certain point
	$(window).scroll(function() {

    // Fixed navigation in certain point
    if (!$('.site-header').hasClass("sticky")) {
      if( $(this).scrollTop() >= $('.site-content').offset().top +20 ) {
        $(".site-header").addClass('fixed');
        $(".site-header").removeClass('deactivated');
      } else {
        $(".site-header").removeClass('fixed');
        $(".site-header").addClass('deactivated');
      }
    }

    // Hide after certain amount
    if( '.scroll-down' != undefined) {

      var scroll = $(window).scrollTop();
      if (scroll >= 200) {
        $(".scroll-down").addClass("fadeout");
      } else {
        $(".scroll-down").removeClass("fadeout");
      }

    }

	});

  $(function() {

    // Prevent 100vh slides from "jumping" when browsing on mobile and address bar goes hidden
    function greedyJumbotron() {
        var HEIGHT_CHANGE_TOLERANCE = 100; // Approximately URL bar height in Chrome on tablet

        var jumbotron = $(this);
        var viewportHeight = $(window).height();

        $(window).resize(function () {
            if (Math.abs(viewportHeight - $(window).height()) > HEIGHT_CHANGE_TOLERANCE) {
                viewportHeight = $(window).height();
                update();
            }
        });

        function update() {
            jumbotron.css('height', viewportHeight + 'px');
        }

        update();
    }

    $('.slide-front-page, .slide-hero-contributions').each(greedyJumbotron);

    var dude_cookie_status = Cookies.get( 'dude_cookie_status' );
    if( dude_cookie_status === 'dismiss' ) {
      $('.cookie-notification-wrapper').remove();
    }

    // Make cookie notification clickable on iOS/iPhone SE
    var ua = navigator.userAgent,
    event = (ua.match(/iPad/i) || ua.match(/iPhone/)) ? 'touchstart' : 'click';

    $('body').on(event, '.cookie-notification-wrapper a', function(e) {
      $('.cookie-notification-wrapper').addClass('fadeout');

      Cookies.set( 'dude_cookie_status', 'dismiss', { expires: 3650 } );

      $('.cookie-notification-wrapper').addClass('fadeout');

      setTimeout( function(){
        $('.cookie-notification-wrapper').remove();
      }, 1000 );
    });

    $('.cookie-notification-wrapper a.button').on('click', function(e) {
      e.preventDefault();

      Cookies.set( 'dude_cookie_status', 'dismiss', { expires: 3650 } );

      $('.cookie-notification-wrapper').addClass('fadeout');

      setTimeout( function(){
        $('.cookie-notification-wrapper').remove();
      }, 1000 );
    });

    // Allow adding regular url in comment form without having to type http
    if( $('input#url').length ) {
      $("input#url").keydown(function() {
        if (!/^http:\/\//.test(this.value)) {
          this.value = "http://" + this.value;
        }
      });
    }

    // Auto expanding textarea
    autosize( $('textarea') );

    // On click to contributions
    $(".slide-hero-contributions .button").click(function(e) {
    	e.preventDefault();

        $('html, body').animate({
            scrollTop: $("#kontribuutiot").offset().top -50
        }, 1000);
    });

    // On click to scroll down arrow
    $(".scroll-down a").click(function(e) {
    	e.preventDefault();

        $('html, body').animate({
            scrollTop: $(".scroll-down-anchor").offset().top -50
        }, 1000);
    });

    // Open chat
    $('.start-chat').on('click', function(event) {
      event.preventDefault();
      $crisp.do('chat:open');
    });

    // Smooth scroll to top
  	$('.top').on('click', function(event) {
  		event.preventDefault();

      $( this ).addClass('launched');

      setTimeout(function() {
        $('.top').removeClass('launched');
      }, 1500);

  		$('body, html').animate({
  			scrollTop: 0,
  		 	}, 700
  		);
  	});

  });

  // Last drunk coffee time formatting
  moment.locale( 'fi' );
  if( $('.coffee-text > span').text() !== '0' ) {
    var time = $('.coffee-time').data('time');
    var timeago = moment( time ).fromNow();
    $('.coffee-time span').html( timeago );
  }

  // Poll if new coffee is being drunk while on page
  function askForCoffee() {
    jQuery.ajax({
      method: 'GET',
      url: 'https://coffter.dude.fi/v1/coffee/drunk/week',
      crossDomain: true,
      dataType: 'jsonp',
    }).done( function( response ) {
      if( response.length !== 0 && response !== false ) {
        if( response.details.latest_entry ) {
          var timeago = moment( response.details.latest_entry ).fromNow();
          $('.coffee-text span').html( response.details.count );
          $('.coffee-time span').html( timeago );
        }
      }
    }).always( function() {
      setTimeout( askForCoffee, 5000 );
    });
  }

  setTimeout( askForCoffee, 5000 );

  var delay = (function(){
    var timer = 0;
    return function(callback, ms){
      clearTimeout (timer);
      timer = setTimeout(callback, ms);
    };
  })();

} )( jQuery );

function check_user_likes( target_class ) {
  jQuery.each( jQuery(target_class), function() {
    var user_likes = JSON.parse( localStorage.getItem( 'dude_liked_posts' ) );
    if( user_likes === null ) {
      user_likes = [];
    }

    var post_id = jQuery(this).attr('id');
    if( post_id !== undefined ) {
      post_id = post_id.substr( post_id.indexOf( "-" ) + 1 );

      if( jQuery.inArray( parseInt( post_id ), user_likes ) > -1 ) {
        jQuery(this).find('.likes').addClass('liked');
      }
    }
  });
}

check_user_likes( 'article.post' );
