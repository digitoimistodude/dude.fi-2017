jQuery(function(){
  // On click to contributions
  jQuery(".block-hero-contributions .button").click(function(e) {
    e.preventDefault();

      jQuery('html, body').animate({
          scrollTop: jQuery("#kontribuutiot").offset().top -50
      }, 1000);
  });

  jQuery('.block-contributions .wrapper > .col').each(function() {
    var time = jQuery(this).find('.timeago').data('date');
    var timeago = moment( time ).fromNow();
    jQuery(this).find('.timeago').html( timeago );
  });
});
