<?php the_post();
/**
 * Contact template
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * Template Name: Contact
 *
 * @package dude
 */

// Persons grid content
$persons_query = new WP_Query( array(
 'post_type'               => 'person',
 'post_status'             => 'publish',
 'posts_per_page'          => 6,
 'order'						       => 'ASC',
 'orderby'					       => 'menu_order title',
 'no_found_rows'           => true,
 'update_post_term_cache'  => false
) );

// Contact details content
$contact_title = get_option( 'dude_contact_title' );
$contact_company_name = get_option( 'dude_contact_company_name' );
$contact_company_business_id = get_option( 'dude_contact_company_business_id' );
$contact_address_row1 = get_option( 'dude_contact_address_row1' );
$contact_address_row2 = get_option( 'dude_contact_address_row2' );
$contact_email = get_option( 'dude_contact_email' );
$contact_phone = get_option( 'dude_contact_person_phone' );

// Start outputting the page
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

      <div class="slide slide-contact-form">

        <div class="container">
          <?php the_content(); ?>
          <noscript><p style="margin-top: 2rem;color:orange;"><?php _e( 'Lomake vaatii valitettavasti javascriptin toimiakseen. Salli JavaScriptin käyttö ja kokeile uudestaan, tai <a href="mailto:moro@dude.fi">lähetä meille sähköpostia</a>.', 'dude' ); ?></p></noscript>
          <?php echo do_shortcode( '[libre-form id="2048"]' ); ?>
        </div><!-- .container -->

      </div><!-- .slide -->

      <div class="slide slide-dude-contact-info">

        <div class="dudes">
          <?php if( $persons_query->have_posts() ):
            while( $persons_query->have_posts() ):
              $persons_query->the_post();

              // exclude emmi and arto
              if ( 3505 === get_the_id() || 3504 === get_the_id() ) {
                continue;
              }

              $image_id = get_post_meta( get_the_id(), '_quote_image', true );
              $job_title = get_post_meta( get_the_id(), '_job_title', true );
              $email = get_post_meta( get_the_id(), '_email', true );
              $phone = get_post_meta( get_the_id(), '_phone', true ); ?>
              <div class="dude" style="background-image: url('<?php echo wp_get_attachment_url( $image_id ) ?>')">
                <a href="<?php the_permalink(); ?>" class="permalink" aria-label="<?php _e( 'Lue lisää henkilöstä ', 'dude' ); ?> <?php the_title(); ?>"></a>
                <div class="shade"></div>

                <div class="dude-content">
                  <h2 class="dude-title"><?php the_title(); ?></h2>
                  <p class="dude-title"><?php echo $job_title; ?></p>

                  <p class="contact-info"><a href="mailto:<?php echo $email ?>"><?php echo $email ?></a><br />
                    <a href="tel:<?php echo str_replace( ' ', '', $phone ) ?>"><?php echo $phone ?></a></p>
                </div>
              </div>
            <?php endwhile;
          endif; ?>
        </div><!-- .dudes -->

        <div class="company-info">

          <div class="company-content">

            <h2><?php _e( 'Tokko ota yhteyttä', 'dude' ); ?></h2>
            <h3><?php echo $contact_company_name; ?></h3>
            <?php if( !empty( $contact_company_business_id ) ): ?>
              <p><?php _e( 'Y-tunnus', 'dude' ) ?>: <a href="https://www.asiakastieto.fi/yritykset/FI/digitoimisto-dude-oy/25480215/yleiskuva" target="_blank"><?php echo $contact_company_business_id ?></a></p>
            <?php endif; ?>
            <p>
              <a href="mailto:<?php echo $contact_email ?>"><?php echo $contact_email ?></a><br>
              <a href="tel:<?php echo str_replace( ' ', '', $contact_phone ) ?>"><?php echo $contact_phone ?></a>
            </p>

          </div>

        </div><!-- .company-info -->

      </div><!-- .slide -->

      <div class="slide slide-location">
        <div class="col col-map" id="map"></div>
        <div class="col col-office"></div>
      </div>

		</main><!-- #main -->
	</div><!-- #primary -->

<script>
function initMap() {
  var dude = {lat: 62.239363, lng: 25.744733};
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: dude,
    scrollwheel: false,
    navigationControl: false,
    mapTypeControl: false,
    scaleControl: false,
    styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"lightness":20},{"color":"#ececec"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"on"},{"color":"#f0f0ef"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#f0f0ef"}]},{"featureType":"landscape.man_made","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#d4d4d4"}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"visibility":"on"},{"color":"#ececec"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"lightness":21},{"visibility":"off"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#d4d4d4"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#303030"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"saturation":"-100"}]},{"featureType":"poi.attraction","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.government","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"featureType":"poi.place_of_worship","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.school","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.school","elementType":"geometry.stroke","stylers":[{"lightness":"-61"},{"gamma":"0.00"},{"visibility":"off"}]},{"featureType":"poi.sports_complex","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#dadada"},{"lightness":17}]}]
  });
  var marker = new google.maps.Marker({
    position: dude,
    icon: '<?php echo get_theme_file_uri( 'images/dude-map-marker-50px.png' ) ?>',
    map: map
  });
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWW6SIJ3AJv3PIrqu1FYkjTzBhzEmWcUY&callback=initMap"></script>

<?php get_footer();
