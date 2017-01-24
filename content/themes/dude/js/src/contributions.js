jQuery(function(){
  jQuery('.slide-contributions .wrapper > .col').each(function() {
    var time = jQuery(this).find('.timeago').data('date');
    var timeago = moment( time ).fromNow();
    jQuery(this).find('.timeago').html( timeago );
  });
});
