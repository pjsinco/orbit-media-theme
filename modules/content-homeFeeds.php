<div class="outer-row feeds">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-8 col-md-6 feed blog">
                <header class="feed--title">
                    <a href="/health-library/">The Health Library&nbsp;&rsaquo;</a>
                </header> <!--  .feed--title -->
                <section class="feed--output">

                    <?php
                        $args = array(

                            // Type & Status Parameters
                            'post_status' => 'publish',
                            'post_type'   => array( 'post' ),

                            // Order & Orderby Parameters
                            'order'               => 'DESC',
                            'orderby'             => 'date',
                            'ignore_sticky_posts' => true,

                            // Pagination Parameters
                            'posts_per_page' => 3,

                        );

                        $blog_posts = new WP_Query( $args );
                    ?>

                    <?php if ( $blog_posts->have_posts() ) : ?>
                        <?php while( $blog_posts->have_posts() ) : $blog_posts->the_post() ?>

                            <div <?php post_class('post row') ?>>
                                <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                                    <div class="col-sm-4 col-md-3">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'medium', array( 'title' => get_the_title( $post ) ) ); ?>
                                        </a>
                                    </div> <!--  .col-sm-3 -->
                                <?php endif; ?>
                                <div class="<?php echo (( has_post_thumbnail( $post->ID ) ) ? 'col-sm-8 col-md-9' : 'col-xs-12' ); ?>">
                                    <div class="meta">

                                    </div>
                                    <span class="post--title"><a href="<?php the_permalink(); ?>"><?php the_title() ?>&nbsp;&rsaquo;</a></span>
                                    <div class="meta">
                                        <span class="categories"><?php the_category( ', ', '', $post->ID ); ?></span>
                                        <!-- <span class="author"><i class="fa fa-user"></i> <i><?php echo get_the_author(); ?></i></span> -->
                                        <!-- <span class="meta--date"><?php echo get_post_time( 'n.j.y' ); ?></span> -->
                                    </div> <!-- .meta -->
                                </div>
                            </div>
                        <?php endwhile; ?>

                    <?php else: ?>
                        <p>No Results</p>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>

                </section> <!--  .feed--output -->
            </div> <!--  .col-md-4 feed -->
            <div class="col-sm-8 col-md-6 feed faqs">
                <header class="feed--title">
                    <a href="/faqs/">FAQs&nbsp;&rsaquo;</a>
                </header> <!--  .feed--title -->
                <section class="feed--output">

                    <?php
                        $args = array(

                            // Type & Status Parameters
                            'post_status' => 'publish',
                            'post_type'   => array( 'FAQ' ),

                            // Order & Orderby Parameters
                            'order'               => 'DESC',
                            'orderby'             => 'date',
                            'ignore_sticky_posts' => false,

                            // Pagination Parameters
                            'posts_per_page' => 5,

                        );

                        $faqs = new WP_Query( $args );
                    ?>

                    <?php if ( $faqs->have_posts() ) : ?>
                        <?php while( $faqs->have_posts() ) : $faqs->the_post() ?>

                            <div <?php post_class('post row') ?>>
                                <div class="col-xs-12">
                                    <span class="post--title"><?php the_field( 'question', $post->ID ); ?>&nbsp;<a href="<?php the_permalink(); ?>">Answer&nbsp;&rsaquo;</a></span>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    <?php else: ?>
                        <p>No Results</p>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>

                </section> <!--  .feed--output -->
            </div> <!--  .col-md-4 faqs -->
        </div> <!--  .row -->

    </div> <!-- .container-fluid -->
</div> <!--  .outer-row feeds -->
