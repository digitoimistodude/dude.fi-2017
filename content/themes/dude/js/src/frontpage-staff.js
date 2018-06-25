jQuery(document).ready(function() {
	jQuery('.block-staff .col').hover( function() {
		jQuery(this).removeClass('col-open');
      jQuery('.block-staff .col').not(this).addClass('col-set-smaller');
      jQuery(this).addClass('col-open');
	}, function() {
      jQuery('.block-staff .col').removeClass('col-set-smaller');
      jQuery(this).removeClass('col-open');
	});
});
