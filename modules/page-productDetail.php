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

    <?php $bodyClass = get_layout_class(is_active_sidebar( 'sidebar-1' ), $outputLeftPageData); ?>

    <div class="<?php echo $bodyClass; ?> interior-content">

        <?php
            //LEFT
            echo $outputLeftPageData;
        ?>

        <div id="right">
            <div class="row">
				<?php
					/**
					 * woocommerce_before_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
					 * @hooked woocommerce_breadcrumb - 20
					 */
					do_action( 'woocommerce_before_main_content' );
				?>
                <div class="mainContent woocommerce" id="content">
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
							/**
							 * woocommerce_before_single_product hook
							 *
							 * @hooked wc_print_notices - 10
							 */
							 do_action( 'woocommerce_before_single_product' );

							 if ( post_password_required() ) {
							 	echo get_the_password_form();
							 	return;
							 }
						?>

						<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

							<?php
								/**
								 * woocommerce_before_single_product_summary hook
								 *
								 * @hooked woocommerce_show_product_sale_flash - 10
								 * @hooked woocommerce_show_product_images - 20
								 */
								do_action( 'woocommerce_before_single_product_summary' );
							?>

							<div class="summary entry-summary">

								<?php
									/**
									 * woocommerce_single_product_summary hook
									 *
									 * @hooked woocommerce_template_single_title - 5
									 * @hooked woocommerce_template_single_rating - 10
									 * @hooked woocommerce_template_single_price - 10
									 * @hooked woocommerce_template_single_excerpt - 20
									 * @hooked woocommerce_template_single_add_to_cart - 30
									 * @hooked woocommerce_template_single_meta - 40
									 * @hooked woocommerce_template_single_sharing - 50
									 */
									do_action( 'woocommerce_single_product_summary' );
								?>

							</div><!-- .summary -->

							<?php
								/**
								 * woocommerce_after_single_product_summary hook
								 *
								 * @hooked woocommerce_output_product_data_tabs - 10
								 * @hooked woocommerce_upsell_display - 15
								 * @hooked woocommerce_output_related_products - 20
								 */
								do_action( 'woocommerce_after_single_product_summary' );
							?>

							<meta itemprop="url" content="<?php the_permalink(); ?>" />

						</div><!-- #product-<?php the_ID(); ?> -->

						<?php do_action( 'woocommerce_after_single_product' ); ?>


					<?php endwhile; // end of the loop. ?>

				<?php
					/**
					 * woocommerce_after_main_content hook
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );
				?>

				<?php
					/**
					 * woocommerce_sidebar hook
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					do_action( 'woocommerce_sidebar' );
				?>
				 </div><!-- #content -->

                <div id="sidebar"><?php dynamic_sidebar('blog'); ?></div><!-- #sidebar -->
            </div><!-- .row -->
        </div><!-- #right -->
    </div><!-- .interior-content -->
</div><!-- .container-fluid -->
