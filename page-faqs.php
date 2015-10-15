<?php get_header(); ?>

<?php get_template_part( 'modules/content', 'interiorHero' ); ?>

<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>

        <div id="interior">

            <div class="container-fluid">

                <?php $bodyClass = get_layout_class(true); ?>

                <div class="<?php echo $bodyClass; ?> interior-content">

                    <?php
                        // LEFT
                        echo $outputLeftPageData;
                    ?>

                    <div id="right">
                        <div class="row">

                            <div id="content" class="mainContent faqs">

                                <?php echo pageTitle(); ?>

                                <div class="entry facetwp-template">
                                    <?php
                                        /**
                                         * The WordPress Query class.
                                         * @link http://codex.wordpress.org/Function_Reference/WP_Query
                                         *
                                         */
                                        $args = array(

                                            // Type & Status Parameters
                                            'post_status' => 'publish',
                                            'post_type'   => array( 'FAQ' ),

                                            // Order & Orderby Parameters
                                            'order'               => 'DESC',
                                            'orderby'             => 'date',
                                            'ignore_sticky_posts' => false,

                                            // Pagination Parameters
                                            'posts_per_page' => -1,

                                        );

                                        $faqs = new WP_Query( $args );

                                        if ( $faqs->have_posts() ) {
                                            while ( $faqs->have_posts() ) : $faqs->the_post();
                                                echo '
                                                    <div class="'. implode(' ', get_post_class('post') ) .'">
                                                        <span class="post--title">'. get_field( 'question', $post->ID ) .'&nbsp;<a href="'. get_permalink() .'">Answer&nbsp;&rsaquo;</a></span>
                                                    </div>
                                                ';
                                            endwhile;
                                        }

                                        /* Restore original Post Data */
                                        wp_reset_postdata();
                                    ?>
                                </div> <!-- .entry -->

                            </div> <!-- #content -->

                            <div id="sidebar"><?php dynamic_sidebar('sidebar-faq'); ?></div>

                        </div> <!-- .row -->
                    </div> <!-- #right  -->

                </div> <!-- .<?php echo $bodyClass; ?>.interior-content -->

            </div> <!-- .container-fluid -->

        </div> <!-- #interior -->

    <?php endwhile; ?>
<?php endif; ?>

<?php PageBlocks::output(); ?>

<?php get_footer(); ?>
