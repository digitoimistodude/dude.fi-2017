<?php

// Contact person content
$contact_person_title = get_option( 'dude_contact_person_title' );
$contact_person_name = get_option( 'dude_contact_person_name' );
$contact_person_email = get_option( 'dude_contact_person_email' );
$contact_person_phone = get_option( 'dude_contact_person_phone' );

// Support content
$support_title = get_option( 'dude_support_title' );
$support_email = get_option( 'dude_support_email' );
$support_phone = get_option( 'dude_support_phone' );
$support_show_chat = get_option( 'dude_support_show_chat' );

// General contact content
$contact_title = get_option( 'dude_contact_title' );
$contact_company_name = get_option( 'dude_contact_company_name' );
$contact_address_row1 = get_option( 'dude_contact_address_row1' );
$contact_address_row2 = get_option( 'dude_contact_address_row2' );
$contact_email = get_option( 'dude_contact_email' );

// Social links content
$social_title = get_option( 'dude_social_title' );
$social_links = carbon_get_theme_option( 'dude_social_links', 'complex' );
$social_bottomline = get_option( 'dude_social_bottomline' );

// Get coffee drunk
$coffee = dude_get_coffee_drunk(); ?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

    <div class="slide slide-footer">
      <div class="container">

        <?php if( !empty( $contact_person_title ) && !empty( $contact_person_name ) && ( !empty( $contact_person_email ) || !empty( $contact_person_phone ) ) ): ?>
          <div class="col col-customers">
            <h3><?php echo $contact_person_title ?></h3>
            <p><?php echo $contact_person_name ?><br />
              <?php if( !empty( $contact_person_email ) ): ?>
                <a href="mailto:<?php echo $contact_person_email ?>"><?php echo $contact_person_email ?></a><br />
              <?php endif;
              if( !empty( $contact_person_phone ) ): ?>
                <a href="tel:<?php echo str_replace( ' ', '', $contact_person_phone ); ?>"><?php echo $contact_person_phone; ?></a>
              <?php endif; ?></p>
          </div><!-- .col -->
        <?php endif;

        if( !empty( $support_title ) && !empty( $support_email ) ): ?>
          <div class="col col-support">
            <h3><?php echo $support_title ?></h3>
            <?php if( $support_show_chat === 'yes' ): ?>
              <p><a href="#" class="start-chat" data-hover="<?php esc_html_e( 'Apuva!', 'dude' ); ?>"><span><?php esc_html_e( 'Kysy chatissa', 'dude' ); ?></span></a><br />
            <?php endif; ?>
            <a href="mail:<?php echo $support_email ?>"><?php echo $support_email ?></a><br />
            <?php if( !empty( $support_phone ) ): ?>
              <a href="tel:<?php echo str_replace( ' ', '', $support_phone ); ?>"><?php echo $support_phone; ?></a>
            <?php endif; ?></p>
          </div><!-- .col -->
        <?php endif;

        if( !empty( $contact_title ) && !empty( $contact_company_name ) && !empty( $contact_email ) ): ?>
          <div class="col col-company">
              <h3><?php echo $contact_title ?></h3>
              <p><?php echo $contact_company_name ?><br />
              <?php if( !empty( $contact_address_row1 ) && !empty( $contact_address_row2 ) ):
                echo $contact_address_row1.'<br />';
                echo $contact_address_row2.'<br />';
              endif; ?>
              <a href="mailto:<?php echo $contact_email ?>"><?php echo $contact_email ?></a></p>
          </div><!-- .col -->
        <?php endif; ?>

      </div><!-- .container -->
    </div><!-- .slide -->

    <div class="slide slide-end">

      <div class="container">

        <div class="col col-left">
          <p>
            <?php if( !empty( $social_title ) && !empty( $social_links ) ):
              $i = 0; $links_total = count( $social_links );
              echo $social_title.' ';

              foreach( $social_links as $link ): ?>
                <a href="<?php echo $link['url'] ?>" target="_blank"><?php echo $link['content'] ?></a><?php if( $i < $links_total-2 ):
                  echo ',';
                elseif( $i < $links_total-1 ):
                  _e( ' ja', 'dude' );
                elseif( $i < $links_total ):
                  echo '.';
                endif;
              $i++; endforeach;
            endif;

            if( !empty( $social_bottomline ) ): ?>
              <br /><?php echo $social_bottomline;
            endif; ?>
          </p>

          <?php if ( ! empty( $coffee ) ) : ?>
            <div class="coffee">

              <div class="coffee-cup-animation" aria-hidden="true">
                  <div class="steam-container">
                    <div class="squiggle-container squiggle-container-1">
                    <div class="squiggle">
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 28.1 80.6" style="enable-background:new 0 0 28.1 80.6;" xml:space="preserve">
                      <path class="" fill="none" stroke-width="3" stroke-linecap="round" stroke-miterlimit="10" d="M22.6,75.1c-8-5.6-15.2-10.5-15.2-19.9c0-12.1,14.1-17.2,14.1-29.6c0-9.1-6.7-15.7-16-20.1"/>
                      </svg>
                    </div> <!-- end .squiggle-->
                  </div>
                    <div class="squiggle-container squiggle-container-2">
                    <div class="squiggle">
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 28.1 80.6" style="enable-background:new 0 0 28.1 80.6;" xml:space="preserve">
                      <path class="" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-miterlimit="10" d="M22.6,75.1c-8-5.6-15.2-10.5-15.2-19.9c0-12.1,14.1-17.2,14.1-29.6c0-9.1-6.7-15.7-16-20.1"/>
                      </svg>
                    </div> <!-- end .squiggle-->
                  </div>
                    <div class="squiggle-container squiggle-container-3">
                    <div class="squiggle">
                      <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="0 0 28.1 80.6" style="enable-background:new 0 0 28.1 80.6;" xml:space="preserve">
                      <path class="" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-miterlimit="10" d="M22.6,75.1c-8-5.6-15.2-10.5-15.2-19.9c0-12.1,14.1-17.2,14.1-29.6c0-9.1-6.7-15.7-16-20.1"/>
                      </svg>
                    </div> <!-- end .squiggle-->
                  </div>
                  </div>
                  <div class="coffee-cup-container">
                    <svg class="coffee-cup" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 42.15 31">
                      <path class="a" d="M30.06,2V23.75c0,2.63-.87,5.13-5.12,5.13H7.06A4.86,4.86,0,0,1,2,23.81V2H30.06Z" transform="translate(0 -0.06)"/>
                      <path class="b" d="M40.64,9.52a10.2,10.2,0,0,0-8.64-5V0.06H0V23.81a7,7,0,0,0,7.06,7.24H24.94c2.34,0,6.06-.81,6.93-5.18a10.6,10.6,0,0,0,8.89-5.29A11.29,11.29,0,0,0,40.64,9.52ZM28,23.75c0,2.07-.42,3.31-3.06,3.31H7.06A3,3,0,0,1,4,23.81V4.06H28V23.75Zm9.26-5.17A7.13,7.13,0,0,1,32,21.78V8.45a7,7,0,0,1,5.18,3.1A7.24,7.24,0,0,1,37.26,18.58Z" transform="translate(0 -0.06)"/>
                    </svg>

                  </div>
                </div><!-- end coffee-container -->

              <p class="coffee-text">
                <span><?php echo $coffee['details']['count'] ?></span> <?php _e( 'kuppia kahvia juotu tällä viikolla.', 'dude' ) ?> <em class="coffee-time" data-time="<?php echo $coffee['details']['latest_entry'] ?>"><?php _e( 'Viimeksi', 'dude' ); ?> <span><?php if( $coffee['details']['count'] > 0 ): echo date_i18n( ' d.m.Y H:i:s', strtotime( $coffee['details']['latest_entry'] ) ); else: _e ( 'viime viikolla', 'dude' ); endif; ?></span></em></p>
            </div>
          <?php endif; ?>

        </div><!-- .col -->

        <div class="col col-right">

          <div class="logos">
            <a href="http://koodiasuomesta.fi/" target="_blank" title="<?php _e( 'Teemme suomalaista koodia', 'dude' ) ?>" class="koodiasuomesta"><?php echo file_get_contents( get_theme_file_path( 'svg/koodiasuomesta.svg' ) ); ?></a>
            <a href="https://www.viestintavirasto.fi/fiverkkotunnus/tietoavalittajalle.html" target="_blank" title="<?php _e( '.fi-verkkotunnusvälittäjä', 'dude' ) ?>" class="valittaja"><?php echo file_get_contents( get_theme_file_path( 'svg/valittaja-tunnus.svg' ) ); ?></a>
            <a href="<?php echo get_page_link( 2446 ); ?>" title="<?php _e( 'Käytämme vihreää tuulienergiaa', 'dude' ) ?>" class="greenweb"><?php echo file_get_contents( get_theme_file_path( 'svg/green-web.svg' ) ); ?></a>
          </div><!-- .logos -->

          <a href="https://status.dude.fi" target="_blank" class="adminlabs-status"><span class="status"></span> Palvelimen tila</a>

        </div><!-- .col -->

      </div><!-- .container -->
    </div><!-- .slide -->

	</footer><!-- #colophon -->

</div><!-- #page -->

</div><!-- .site-wrapper -->

<?php wp_footer(); ?>

<script>CRISP_WEBSITE_ID = "-K90vfAnyk27kD-pZAep"</script>
<script async src="https://client.crisp.im/l.js"></script>

<div class="cookie-notification-wrapper">
  <div class="content">
    <div class="content-text">
      <p><b>Me seurataan sua!</b> ...eli sivusto käyttää evästeitä. <a href="https://www.dude.fi/evasteet">Mitä ihmettä?</a></p>
    </div>

    <p class="button-wrapper"><a href="#" class="button">Asia kunnossa</a></p>
  </div>
</div>
</body>
</html>
