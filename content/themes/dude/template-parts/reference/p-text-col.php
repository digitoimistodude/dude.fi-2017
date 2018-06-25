<?php if( !empty( $part['col1'] ) && !empty( $part['col2'] ) ): ?>
  <div class="block block-customer-story block-customer-story-columns-onlytext">

    <div class="container">

      <div class="general-description">

        <div class="column column-text">

          <?php if( !empty( $part['sub_title'] ) ): ?>
            <h2><span class="order-number"><?php printf( '%02d', $text_area_numbering ); ?></span> <?php echo $part['sub_title'] ?></h2>
          <?php $text_area_numbering++; endif;

          if( !empty( $part['title'] ) ): ?>
            <h3><?php echo $part['title'] ?></h3>
          <?php endif; ?>

          <div class="cols">
            <div class="col">
              <?php echo wpautop( $part['col1'] ) ?>
            </div>

            <div class="col">
              <?php echo wpautop( $part['col2'] ) ?>
            </div><!-- .col -->
          </div><!-- .cols -->

        </div><!-- .column-text -->

      </div><!-- .general-description -->

    </div><!-- .container -->

  </div><!-- .block -->
<?php endif; ?>
