<div class="container-fluid">

    <?php $bodyClass = get_layout_class(true); ?>

    <div class="<?php echo $bodyClass; ?> interior-content">

        <div id="right">

            <p class="back-link"><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">&lsaquo;&nbsp;Back to Health Library</a></p>

            <div class="row">
                <div class="mainContent" id="content">
                <!-- WordPress Loop: Only happens if there are posts. -->
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : ?>

                        <?php the_post(); ?>

                        <!-- post -->
                        <div id="post-<?php the_ID(); ?>" class="post detail">

                            <h1 class="entry-title"><?php the_title(); ?></h1>

                            <?php
                                if ( function_exists( 'has_post_thumbnail' ) && has_post_thumbnail() ) {
                                    // Return the thumbnail for this post..
                                    // echo '<div class="detail-featured-img">'.get_the_post_thumbnail().'</div>';
                                }
                            ?>

                            <?php the_content(); ?>

                             <div class="shareWrapper">
                                <div class="shareTitle">
                                    <span>Share This</span>
                                </div><!-- .shareTitle -->
                                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                <div class="addthis_sharing_toolbox"></div>
                            </div><!-- shareWrapper -->

                            <!-- Go to www.addthis.com/dashboard to customize your tools -->
                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55fc5f9b9eed8453" async="async"></script>


                            <!-- THE COMMENTS -->
                           <ol class="commentlist">
                                <?php wp_list_comments(); ?>
                            </ol>


                            <div class="comments-template">
                                <?php comments_template(); ?>
                            </div><!-- .comments-template -->
                        </div><!-- post -->

                    <?php endwhile; ?>
                <?php endif; ?>

                </div><!-- #content -->

                <div id="sidebar">

                    <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                        <div class="widget post--image">
                            <?php the_post_thumbnail( 'medium', array( 'title' => get_the_title( $post ) ) ); ?>
                        </div> <!--  .col-sm-3 col-md-6 post--image -->
                    <?php endif; ?>

                    <?php dynamic_sidebar('sidebar-blog'); ?>
                </div><!-- #sidebar -->
            </div><!-- .row -->
        </div><!-- #right -->
    </div><!-- .interior-content -->
</div><!-- .container-fluid -->
