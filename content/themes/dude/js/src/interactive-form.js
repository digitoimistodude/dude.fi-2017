( function( $ ) {

  $(function() {

    // If js is activated, remove no-js class
    $('form .form-wrapper').removeClass('no-js');
    $('form .form-wrapper textarea').addClass('force-hidden');

    // If it's Safari
    if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
      // Do nothing - animations are laggy
    } else {
      // Enable animations after a while to prevent flickering on document ready
      setTimeout(function(){
        $('form .form-wrapper').addClass('animated');
      }, 1000);
    }

    // Wplf submit callback
    window.wplf.successCallbacks.push( function( response ) {
      $('.slide-contact-form h1').html( 'Kohta tanssitaan!' )
      $('.slide-contact-form .container > p:first-of-type').hide()
      fitvids();

      var position = $('.wplf-success').offset();
      $('html, body').animate({ scrollTop: position.top-250 }, 500);
    } );

    // Events for input typing
    var typingTimer;
    var doneTypingInterval = 800;

    $('form #name').on('input', function() {
      clearTimeout( typingTimer );

      typingTimer = setTimeout( function() {
        var name = $('form #name').val();
        name = name.split(/(\s+)/);

        $('form .say-wrapper.message').addClass('visible');
        $('form p.sayatme.message').addClass('type');
        $('form p.sayatme.message').html( dudeinteractiveform.sayatmemessage.replace( '{{ name }}', name[0] ) );
        $('form .form-wrapper textarea').removeClass('force-hidden');
        $('form #message, .phase.second').addClass('active');
      }, doneTypingInterval );
    });

    $('form #message').on('input', function() {
      clearTimeout( typingTimer );

      typingTimer = setTimeout( function() {
        $('form .say-wrapper.email').addClass('visible');
        $('form p.sayatme.email').addClass('type');
        $('form p.sayatme.email').html( dudeinteractiveform.sayatmeemail );
        $('form #email, .phase.third').addClass('active');
      }, doneTypingInterval );
    });

    $('form #email').on('input', function() {
      clearTimeout( typingTimer );

      typingTimer = setTimeout( function() {
        $('form .say-wrapper.phone').addClass('visible');
        $('form p.sayatme.phone').addClass('type');
        $('form p.sayatme.phone').html( dudeinteractiveform.sayatmephone );
        $('form #phone, form button').addClass('active');
      }, doneTypingInterval );
    });

    // Events for input focus
    $('form #message').focus( function() {
      clearTimeout( typingTimer );

      var name = $('form #name').val();
      name = name.split(/(\s+)/);

      $('form .say-wrapper.message').addClass('visible');
      $('form p.sayatme.message').addClass('type');
      $('form p.sayatme.message').html( dudeinteractiveform.sayatmemessage.replace( '{{ name }}', name[0] ) );
      $('form #message, .phase.second').addClass('active');
    });

    $('form #email').focus( function() {
      clearTimeout( typingTimer );

      $('form .say-wrapper.email').addClass('visible');
      $('form p.sayatme.email').addClass('type');
      $('form p.sayatme.email').html( dudeinteractiveform.sayatmeemail );
      $('form #email, .phase.third').addClass('active');
    });

    $('form #phone').focus( function() {
      clearTimeout( typingTimer );

      $('form .say-wrapper.phone').addClass('visible');
      $('form p.sayatme.phone').addClass('type');
      $('form p.sayatme.phone').html( dudeinteractiveform.sayatmephone );
      $('form #phone, form button').addClass('active');
    });

  });

} )( jQuery );
