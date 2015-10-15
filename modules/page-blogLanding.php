<div class="container-fluid">

    <?php $bodyClass = get_layout_class(true); ?>

    <div class="<?php echo $bodyClass; ?> interior-content">

        <div id="right">
            <div class="row">
                <div class="mainContent" id="content">

                    <?php
                        $record_id = get_option( 'page_for_posts' );
                        echo pageTitle( $record_id );
                    ?>

                    <div class="entry">
                        <?php getContentByID( $record_id ); ?>
                    </div>

                    <?php
                        $classes = array(
                            'post',
                            'landing',
                            'row',
                        );
                    ?>
                    <!-- WordPress Loop: Only happens if there are posts. -->
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : ?>
                            <?php the_post(); ?>

                            <!-- post -->
                            <div id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>

                                <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                                    <div class="col-sm-4 col-md-6 post--image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'blog-preview', array( 'title' => get_the_title( $post ) ) ); ?>
                                        </a>
                                    </div> <!--  .col-sm-3 col-md-6 post--image -->
                                <?php endif; ?>

                                <div class="post--content <?php echo (( has_post_thumbnail( $post->ID ) ) ? 'col-sm-8 col-md-6' : 'col-xs-12' ); ?>">

                                    <h2 class="post--title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                                    <div class="post--meta">
                                        <!-- <span class="meta author">
                                            By <?php the_author(); ?>
                                        </span> -->
                                        <!-- <span class="delimiter">|</span> -->
                                        <span class="meta category">
                                            <?php if ( has_category() ) : ?>
                                                <?php the_category( ', ', '', $post->ID ); ?>
                                            <?php endif; ?>
                                        </span>
                                    </div> <!-- .post--meta -->

                                    <div class="post--excerpt">
                                        <?php the_excerpt(); ?>
                                    </div> <!--  .post--excerpt -->
                                </div> <!--  .post--content -->

                                <div class="divider"></div>

                            </div><!-- post -->

                        <?php endwhile; ?>
                    <?php else : ?>

                        <p>Sorry, no posts match your criteria.</p>

                    <?php endif; ?>

                    <!-- postsNavWrapper -->
                    <div class="postsNavWrapper" align="center">
                        <div class="postsNav buttonContainer">
                            <?php
                                if ( function_exists( 'wp_paginate' ) ) {
                                    wp_paginate();
                                } else {
                                    posts_nav_link('&nbsp;&nbsp;&nbsp;&nbsp;', '<span>&lsaquo;&nbsp;</span>Previous', 'Next<span>&nbsp;&rsaquo;</span>');
                                }
                            ?>
                        </div>
                    </div><!-- /postsNav -->

                </div><!-- #content -->

                <div id="sidebar"><?php dynamic_sidebar('sidebar-blog'); ?></div>
            </div><!-- .row -->
        </div><!--#right -->
    </div><!-- .interior-content -->
</div><!--.container-fluid -->
