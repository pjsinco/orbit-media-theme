<?php if ( get_field( 'cta_message', 'options' ) && false == get_field( 'hide_footer_cta', 'options' ) ) : ?>

    <div class="cta">
        <div class="container-fluid">
            <div class="row">

                <div class="table">

                    <div class="cell cta--message">
                        <?php the_field( 'cta_message', 'options' ); ?>
                    </div>

                    <?php if ( get_field( 'cta_button_text', 'options' ) && get_field( 'cta_button_link', 'options' ) ) : ?>

                        <div class="cell cta--button">
                            <a href="<?php the_field( 'cta_button_link', 'options' ); ?>" class="button">
                                <?php the_field( 'cta_button_text', 'options' ); ?>&nbsp;<i class="fa fa-angle-double-right"></i>
                            </a>
                        </div>

                    <?php endif; ?>

                </div>

            </div>
        </div> <!--  .container-fluid -->
    </div> <!--  .cta -->

<?php endif; ?>
