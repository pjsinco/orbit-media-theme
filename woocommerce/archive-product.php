<?php get_header(); ?>

    <div id="interior">
        <?php global $Menu; ?>

        <div class="container-fluid">

            <?php
                $outputLeftPageData = wp_nav_menu( array(
                    'theme_location' => 'primary-menu', // location of menu
                    'container_id'   => 'leftBar',
                    'sub_menu'       => true, // activate custom sub_menu function
                    'echo'           => false, // return menu as variable
                    'menu_id'        => 'subMenu',
                ) );

            ?>

            <?php $bodyClass = get_layout_class(is_active_sidebar( 'sidebar-shop' ), $outputLeftPageData); ?>

            <div class="<?php echo $bodyClass; ?> interior-content woocommerce">

                <?php
                    //LEFT
                    echo $outputLeftPageData;
                ?>

                <div id="right">
                    <div class="row">

                        <div id="content" class="mainContent">

                            <?php echo pageTitle(); ?>

                            <div class="entry">
                                <?php do_action( 'woocommerce_archive_description' ); ?>

                                <div class="facetwp-template">

                                    <?php if ( have_posts() ) : ?>

                                        <?php
                                            /**
                                             * woocommerce_before_shop_loop hook
                                             *
                                             * @hooked woocommerce_result_count - 20
                                             * @hooked woocommerce_catalog_ordering - 30
                                             */
                                            do_action( 'woocommerce_before_shop_loop' );
                                        ?>

                                        <?php woocommerce_product_loop_start(); ?>

                                            <?php woocommerce_product_subcategories(); ?>

                                            <?php while ( have_posts() ) : the_post(); ?>

                                                <?php wc_get_template_part( 'content', 'product' ); ?>

                                            <?php endwhile; // end of the loop. ?>

                                        <?php woocommerce_product_loop_end(); ?>

                                        <?php
                                            /**
                                             * woocommerce_after_shop_loop hook
                                             *
                                             * @hooked woocommerce_pagination - 10
                                             */
                                            do_action( 'woocommerce_after_shop_loop' );
                                        ?>

                                    <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

                                        <?php wc_get_template( 'loop/no-products-found.php' ); ?>

                                    <?php endif; ?>

                                </div>
                            </div> <!-- .entry -->

                        </div> <!-- #content -->

                        <?php dynamic_sidebar('sidebar-shop'); ?>

                    </div> <!-- .row -->
                </div> <!-- #right  -->

            </div> <!-- .<?php echo $bodyClass; ?>.interior-content -->

        </div> <!-- .container-fluid -->

    </div> <!-- #interior -->

<?php global $PageBlocks; ?>

<!-- Page Blocks
================================================== -->
<?php
    echo $PageBlocks->pageBlocks();
?>

<?php get_footer(); ?>
