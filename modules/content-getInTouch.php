<div class="col-xs-12 col-sm-3 col-md-2 logo">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
        <img src="<?php echo get_template_directory_uri(); ?>/images/aoa_footer_logo.png" alt="<?php bloginfo('name'); ?>">
    </a>
</div> <!-- .logo -->

<div class="col-xs-12 col-sm-5 col-md-3 get-in-touch">

    <div class="address">
        <h3><?php the_field( 'location_title', 'option' ); ?></h3>

        <?php
            $address = get_field( 'contact_address', 'option' );
            if ( ! empty($address)) :
        ?>
        <?php

            $directions = '';
            $address_html = '';

            if ( ! empty($address->street1)) {
                $directions .= urlencode( $address->street1 ) .' ';
                $address_html .= esc_html( $address->street1 ) .'</br>';
            }

            if ( ! empty($address->street2)) {
                $directions .= '';
                $address_html .= esc_html( $address->street2 ) .'</br>';
            }

            if ( ! empty($address->city)) {
                $directions .= '';
                $address_html .= esc_html( $address->city ) .', ';
            }

            if ( ! empty($address->state)) {
                $directions .= '';
                $address_html .= esc_html( $address->state ) .' ';
            }

            if ( ! empty($address->zip)) {
                $directions .= '';
                $address_html .= esc_html( $address->zip );
            }

            $directions = urlencode( trim( $directions ) );

        ?>

        <address>
            <?php echo $address_html; ?>
        </address>

        <?php endif; ?>

        <div class="contact">

            <?php
                $toll = get_field( 'toll_number', 'options' );
                $tel = get_field( 'phone_number', 'options' );
                $fax = get_field( 'fax_number', 'options' );
            ?>

            <div class="contact--toll">
                <?php if ( ! empty( $toll )) : ?>
                    <div>Toll-Free Phone: <?php echo esc_html( $toll ); ?></div>
                <?php endif; ?>
            </div> <!--  .contact--toll -->
            <div class="contact--phone">
                <?php if ( ! empty( $tel )) : ?>
                    <div>Phone: <?php echo esc_html( $tel ); ?></div>
                <?php endif; ?>
            </div> <!--  .contact--phone -->
            <div class="contact--fax">
                <?php if ( ! empty( $fax )) : ?>
                    <div>Fax: <?php echo esc_html( $fax ); ?></div>
                <?php endif; ?>
            </div> <!--  .contact--fax -->

        </div> <!--  .contact -->
    </div> <!--  .address -->
</div> <!--  .col-sm-3 get-in-touch -->
