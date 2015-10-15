<div class="col-xs-12 col-md-4 newsletter">
    <?php if ( get_field( 'news_title', 'options' ) ) : ?>
        <h3><?php the_field( 'news_title', 'options' ); ?></h3>
    <?php endif; ?>
    <?php if ( get_field( 'news_message', 'options' ) ) : ?>
        <?php the_field( 'news_message', 'options' ); ?>
    <?php endif; ?>
    <?php
        if ( function_exists( 'ninja_forms_display_form' ) ) {
            ninja_forms_display_form( 15 );
        }
    ?>
</div> <!--  .col-md-4 newsletter -->
