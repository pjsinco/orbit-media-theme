<div class="container-fluid">
    <?php
        if(is_active_sidebar('white-papers')) {
            $bodyClass = get_layout_class(true);
        }
    ?>
    <div class="<?php echo $bodyClass; ?> interior-content">

        <div id="right">
            <div class="row">
                <div class="mainContent" id="content">

                <!-- WordPress Loop: Only happens if there are posts. -->
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : ?>
                        <?php the_post(); ?>

                        <!-- post -->
                        <div id="post-<?php the_ID(); ?>" class="post landing">

                            <!-- postExcerptsContainer -->
                            <div class="theExcerpts postExcerptsContainer">

                                <!-- postMeta -->
                                <div class="postMeta">
                                    <?php
                                        if (function_exists('has_post_thumbnail')
                                            && has_post_thumbnail()) {

                                            // Return the thumbnail for this post..
                                            echo '<div class="post-image"><a href="'.get_permalink().'">'.get_the_post_thumbnail( $post_id, 'news').'</a></div>';

                                        }
                                    ?>
                                </div><!-- /postMeta -->

                                <div class="postContent">
                                    <h2 class="postTitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <div class="post-date"><span class="fa-calendar"></span> <?php the_time('F j, Y'); ?></div>
                                    <div class="post-categories"><?php echo get_the_term_list( $post->ID, 'white_paper_category', '', ', ', '' ); ?></div>



                                    <!-- postExcerpt -->
                                    <!-- Defaults to 55 chars, strips out all HTML except <a>, <p>, and <strong>. Can be modified in oms-theme-functions.php. -->
                                    <div class="storyContent posts postExcerpt">
                                        <?php the_excerpt(); ?>
                                    </div><!-- /postExcerpt -->
                                </div>

                            </div><!-- /postExcerptsContainer -->

                            <div class="clearer"></div>

                        </div><!-- post -->

                    <?php endwhile; ?>
                <?php else : ?>

                    <p>Sorry, no posts match your criteria.</p>

                <?php endif; ?>

                    <!-- postsNavWrapper -->
                    <div class="postsNavWrapper" align="center">
                        <div class="postsNav buttonContainer">
                            <?php posts_nav_link('&nbsp;&nbsp;&nbsp;&nbsp;', '<span></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Newer Posts', 'Older Posts&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span></span>'); ?>
                        </div>
                    </div><!-- /postsNav -->

                </div><!-- #content -->

                <div id="sidebar"><?php dynamic_sidebar('sidebar-whitePapers'); ?></div>
            </div><!-- .row -->
        </div><!--#right -->
    </div><!-- .interior-content -->
</div><!--.container-fluid -->
