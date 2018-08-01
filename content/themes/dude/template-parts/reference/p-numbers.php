<?php if( !empty( $part['number1_value'] ) && !empty( $part['number1_format'] ) && !empty( $part['number1_label'] ) ): ?>
  <div class="block block-customer-story no-bottom-padding">

    <div class="container">

      <div class="general-description">
        <?php if( !empty( $part['sub_title'] ) ): ?>
          <h2><span class="order-number"><?php printf( '%02d', $text_area_numbering ); ?></span> <?php echo $part['sub_title'] ?></h2>
        <?php $text_area_numbering++; endif; ?>

        <?php if( empty( $part['number2_value'] ) && empty( $part['number2_format'] ) && empty( $part['number2_label'] ) ): ?>
          <div class="numbers">
            <h3 class="number-big"><?php echo $part['number1_value'] ?> <span class="format"><?php echo $part['number1_format'] ?></span>
            <span class="what"><?php echo $part['number1_label'] ?></span></h3>
            <?php if( !empty( $part['number1_updated'] ) ): ?>
              <h4 class="time-updated">(<?php _e( 'Päivitetty', 'dude' ); echo date_i18n( ' j.n.Y', strtotime( $part['number1_updated'] ) ) ?>)</h4>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <div class="numbers numbers-columns">
            <div class="col">
              <h3 class="number-big"><?php echo $part['number1_value'] ?> <span class="format"><?php echo $part['number1_format'] ?></span>
              <span class="what"><?php echo $part['number1_label'] ?></span></h3>
              <?php if( !empty( $part['number1_updated'] ) ): ?>
                <h4 class="time-updated">(<?php _e( 'Päivitetty', 'dude' ); echo date_i18n( ' j.n.Y', strtotime( $part['number1_updated'] ) ) ?>)</h4>
              <?php endif; ?>
            </div><!-- .col -->

            <div class="col">
              <h3 class="number-big"><?php echo $part['number2_value'] ?> <span class="format"><?php echo $part['number2_format'] ?></span>
              <span class="what"><?php echo $part['number2_label'] ?></span></h3>
              <?php if( !empty( $part['number2_updated'] ) ): ?>
                <h4 class="time-updated">(<?php _e( 'Päivitetty', 'dude' ); echo date_i18n( ' j.n.Y', strtotime( $part['number2_updated'] ) ) ?>)</h4>
              <?php endif; ?>
            </div><!-- .col -->
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endif; ?>
