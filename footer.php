<footer class="outer-row">

    <?php get_template_part( 'modules/content', 'footerCTA' ); ?>

    <div class="footer">
        <div class="container-fluid">
            <div class="row">

                <?php get_template_part( 'modules/content', 'getInTouch' ); ?>

                <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container_class' => 'col-xs-12 col-sm-4 col-md-3', 'container_id' => 'footer-links', 'menu_class' => 'menu quick', 'depth' => 1 ) ); ?>

                <?php get_template_part( 'modules/content', 'newsletterSignUp' ); ?>

            </div>
        </div> <!--  .container-fluid -->
    </div> <!--  .footer -->

    <div class="copyright">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xs-12 col-sm-9 copyright--owner">
                    <span><?php bloginfo('name'); ?> &copy; <?php echo date('Y'); ?> </span>
                    <?php wp_nav_menu( array( 'theme_location' => 'copyright-menu', 'container' => false, 'menu_class' => 'menu', 'depth' => 1 ) ); ?>
                </div>

                <div class="col-xs-12 col-sm-3">
                    <?php if (get_field( 'sm_outlets', 'option' )) : ?>
                        <ul class="social-outlets">
                        <?php while(has_sub_field( 'sm_outlets', 'option')) : ?>
                            <li>
                                <a href="<?php the_sub_field( 'sm_link' ); ?>">
                                    <?php the_sub_field( 'sm_icon_code' ); ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </div>

            </div>
        </div> <!--  .container-fluid -->
    </div> <!--  .copyright -->

</footer> <!--  .outer-row -->

<?php wp_footer(); ?>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/faq.js'; ?>" ></script>
<script>
    jQuery(document).ready(function($) {
        $( '.dropdown-toggle' ).on( 'click', function() {
            $( this ).closest( 'li' ).toggleClass( 'open' );
        });
    });
</script>
</body>
</html>
