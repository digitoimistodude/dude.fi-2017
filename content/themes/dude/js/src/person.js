( function( $ ) {
  $(document).ready(function() {
    $('.number:not(.timefrom) .time span').each(function() {
      var timeago = moment( $(this).data('time') ).fromNow();
      $(this).html( timeago );
    });

    $('.number.timefrom .value').each(function() {
      var timeago = moment( $(this).data('time') ).fromNow(true);
      timeago = timeago.split(/(\s+)/);
      $(this).html( timeago[0] );
      $(this).parent().find('.label span').html( timeago[2]+' ' );
    });
  });
} )( jQuery );
