( function( $ ) {

  // Hide fields if js
  $('form #message').addClass('hidden');
  $('form #email').addClass('hidden');
  $('form #phone').addClass('hidden');
  $('form button').addClass('hidden');

  // Wplf submit callback
  window.wplf.successCallbacks.push( function( response ) {
    $('.slide-contact-form h1').html( 'Kohta tanssitaan!' )
    $('.slide-contact-form .container > p:first-of-type').hide()
    fitvids();

    var position = $('.wplf-success').offset();
    $('html, body').animate({ scrollTop: position.top-150 }, 500);
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
      $('form #message').removeClass('hidden');
      $('form #message, .phase.second').addClass('prompt display fadein');

      var position = $('form #name').offset();
      $('html, body').animate({ scrollTop: position.top-175 }, 500);
    }, doneTypingInterval );
  });

  $('form #message').on('input', function() {
    clearTimeout( typingTimer );

    typingTimer = setTimeout( function() {
      $('form .say-wrapper.email').addClass('visible');
      $('form p.sayatme.email').addClass('type');
      $('form p.sayatme.email').html( dudeinteractiveform.sayatmeemail );
      $('form #email').removeClass('hidden');
      $('form #email, .phase.third').addClass('prompt display fadein');

      var position = $('form #message').offset();
      $('html, body').animate({ scrollTop: position.top-175 }, 500);
    }, doneTypingInterval );
  });

  $('form #email').on('input', function() {
    clearTimeout( typingTimer );

    typingTimer = setTimeout( function() {
      $('form .say-wrapper.phone').addClass('visible');
      $('form p.sayatme.phone').addClass('type');
      $('form p.sayatme.phone').html( dudeinteractiveform.sayatmephone );
      $('form #phone, form button').removeClass('hidden');
      $('form #phone').addClass('prompt show display fadein');
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
    $('form #message').removeClass('hidden');
    $('form #message, .phase.second').addClass('prompt display fadein');

    var position = $('form #name').offset();
    $('html, body').animate({ scrollTop: position.top-175 }, 500);
  });

  $('form #email').focus( function() {
    clearTimeout( typingTimer );

    $('form .say-wrapper.email').addClass('visible');
    $('form p.sayatme.email').addClass('type');
    $('form p.sayatme.email').html( dudeinteractiveform.sayatmeemail );
    $('form #email').removeClass('hidden');
    $('form #email, .phase.third').addClass('prompt display fadein');

    var position = $('form #message').offset();
    $('html, body').animate({ scrollTop: position.top-175 }, 500);
  });

  $('form #phone').focus( function() {
    clearTimeout( typingTimer );

    $('form .say-wrapper.phone').addClass('visible');
    $('form p.sayatme.phone').addClass('type');
    $('form p.sayatme.phone').html( dudeinteractiveform.sayatmephone );
    $('form #phone, form button').removeClass('hidden');
    $('form #phone').addClass('prompt display fadein');
  });


} )( jQuery );
