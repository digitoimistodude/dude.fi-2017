jQuery(document).ready(function() {
	jQuery('.slide-staff .col').hover( function() {
		jQuery(this).removeClass('col-open');
      jQuery('.slide-staff .col').not(this).addClass('col-set-smaller');
      jQuery(this).addClass('col-open');
	}, function() {
      jQuery('.slide-staff .col').removeClass('col-set-smaller');
      jQuery(this).removeClass('col-open');
	});
});
