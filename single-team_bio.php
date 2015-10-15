<?php get_header(); ?>

<?php if(have_posts()) : ?>
    <?php while(have_posts()) : the_post(); ?>

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

                <?php $bodyClass = get_layout_class( true, $outputLeftPageData ); ?>

                <div class="<?php echo $bodyClass; ?> interior-content">

                    <?php
                        //LEFT
                        echo $outputLeftPageData;
                    ?>

                    <div id="right">
                        <div class="row">

                            <div id="content" class="mainContent">

                                <?php echo pageTitle(); ?>

                                <div class="entry">
                                    <?php the_content(); ?>
                                </div> <!-- .entry -->

                            </div> <!-- #content .mainContent -->

                            <div id="sidebar">
                                <div id="bioSidebar">
                                    <div id="bioImage"><img class="glyph" src="<?php echo get_field('bio_image'); ?>" alt="<?php echo get_the_title(); ?>" /></div>
                                    <div class="bioSocialMedia">
                                    <?php
                                        // check if the repeater field has rows of data
                                        if( have_rows('social_media') ):

                                            // loop through the rows of data
                                            while ( have_rows('social_media') ) : the_row();

                                                // display a sub field value
                                                echo '<a href="'.get_sub_field('url').'"><div class="fa '.get_sub_field('icon').'"></div>'.get_the_title().' on '.get_sub_field('social_media_name').'</a>';

                                            endwhile;

                                        endif;
                                    ?>
                                    </div> <!-- .bioSocialMedia -->
                                </div> <!-- #bioSidebar -->
                            </div> <!-- #sidebar -->

                        </div> <!--  .row -->
                    </div> <!-- #right -->

                </div> <!-- .<?php echo $bodyClass; ?>.interior-content -->
            </div> <!-- .container-fluid -->
        </div> <!-- #interior -->

    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
