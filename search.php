<?php get_header(); ?>

<div id="interior">

    <div class="container-fluid">
        <div class="interior-content hasLeftAndRightCols">
            <div id="right">
                <div class="row">

                    <div class="mainContent search-results" id="content">

                        <h1>Search Results</h1>
                        <h4 class="search-title">
                            <?php echo $wp_query->found_posts; ?>
                            <?php _e( 'Results found for', 'locale' ); ?> <em>"<?php the_search_query(); ?>"</em>
                        </h4>

                        <?php
                            $classes = array(
                                'post',
                                'landing',
                                'row',
                                'search',
                            );
                        ?>

                        <!-- WordPress Loop: Only happens if there are posts. -->
                        <?php if ( have_posts() ) : ?>
                            <?php while ( have_posts() ) : ?>
                                <?php the_post(); ?>

                                <!-- post -->
                                <div id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>

                                    <div class="post--content col-xs-12">

                                        <h2 class="post--title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                                        <div class="post--excerpt">
                                            <?php //the_excerpt(); ?>
                                            <?php $excerpt = strip_tags(get_the_excerpt()); echo $excerpt; ?>
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

                </div> <!-- .row -->
            </div> <!-- #right -->
        </div> <!-- . interior-content -->
    </div> <!-- .container-fluid -->

</div> <!-- #interior -->

<?php get_footer(); ?>
