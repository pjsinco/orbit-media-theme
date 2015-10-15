<?php get_header(); ?>

<?php get_template_part( 'modules/content', 'interiorHero' ); ?>

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>

        <div id="interior">

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
                        // LEFT
                        echo $outputLeftPageData;
                    ?>

                    <div id="right">
                        <div class="row">

                            <div id="content" class="mainContent">

                                <?php echo pageTitle(); ?>

                                <div class="entry facetwp-template">
                                <?php

                                    if($post->ID == get_field('team_bios_page', 'option')) {
                                        // TEAM BIOS
                                        get_template_part( 'modules/page', 'bios' );

                                    } else {

                                        the_content();

                                    }

                                ?>
                                </div> <!-- .entry -->

                            </div> <!-- #content -->

                            <?php
                                //RIGHT
                                get_sidebar();
                            ?>

                        </div> <!-- .row -->
                    </div> <!-- #right  -->

                </div> <!-- .<?php echo $bodyClass; ?>.interior-content -->

            </div> <!-- .container-fluid -->

        </div> <!-- #interior -->

    <?php endwhile; ?>
<?php endif; ?>

<?php PageBlocks::output(); ?>

<?php get_footer(); ?>
