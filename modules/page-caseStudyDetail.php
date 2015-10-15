<div class="container-fluid">
    <?php
        if(is_active_sidebar('case-studies')) {
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
                        <div id="post-<?php the_ID(); ?>" class="post detail">

                            <h2 class="entry-title"><?php the_title(); ?></h1>

                            <div id="postMeta">
                                <div class="post-date"><?php the_time('F j, Y'); ?></div>
                                <div class="delimiter">/</div>
                                <div class="post-categories"><?php echo get_the_term_list( $post->ID, 'case_study_category', '', ', ', '' ); ?></div>
                            </div><!-- #postMeta -->

                            <?php
                                if(function_exists('has_post_thumbnail') && has_post_thumbnail()) {
                                    // Return the thumbnail for this post..
                                    echo '<div class="detail-featured-img">'.get_the_post_thumbnail().'</div>';
                                }
                            ?>

                            <?php the_content(); ?>


                             <div class="shareWrapper">
                                <div class="shareTitle">
                                    <h3>Share This</h3>
                                </div><!-- .shareTitle -->
                                <div class="addthis_toolbox" addthis:url="" addthis:title="<?php the_title(); ?>" addthis:message="">
                                    <div class="custom_images">
                                        <a class="addthis_button_email"><i class="fa fa-envelope-square"></i></a>
                                        <a class="addthis_button_facebook"><i class="fa fa-facebook-square"></i></a>
                                        <a class="addthis_button_twitter"><i class="fa fa-twitter-square"></i></a>
                                        <a class="addthis_button_linkedin"><i class="fa fa-linkedin-square"></i></a>
                                        <a class="addthis_button_google_plusone_share"><i class="fa fa-google-plus-square"></i></a>
                                    </div>
                                </div><!-- .addthis_toolbox -->

                                <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54ecf4457a90e39c" async="async"></script>
                                <script type="text/javascript">
                                /* http://support.addthis.com/customer/portal/articles/683399-changes-to-how-twitter-works-with-addthis
                                var addthis_share = addthis_share || {}
                                addthis_share = {
                                    passthrough : {
                                        twitter: {
                                            via: ""
                                        }
                                    }
                                }
                                // TODO: Add custom fields to sandbox for this information
                                */

                                /* http://support.addthis.com/customer/portal/articles/1013558-removing-all-hashtags-anchors-weird-codes-from-your-urls
                                var addthis_config = addthis_config||{};
                                addthis_config.data_track_addressbar = false;
                                addthis_config.data_track_clickback = false;
                                */
                                </script>
                                <div class="clear"></div><!-- .clear -->
                            </div><!-- shareWrapper -->


                            <div id="authorBio">
                                <div id="authorGravatar">
                                    <div id="gravatarWrapper">
                                        <?php echo get_avatar(  get_the_author_meta('email'), '65', 'http://example.com/no_avatar.jpg' ); ?>
                                    </div>
                                </div><!-- authorGravatar -->
                                <div id="authorInfo">
                                    <h5><?php the_author(); ?></h5>
                                    <?php
                                        $author_id = get_the_author_meta( 'ID' );
                                        echo get_field('author_bio', 'user_'.$author_id);
                                    ?>
                                </div><!-- #authorInfo -->
                            </div><!-- #authorBio -->

                            <!-- THE COMMENTS -->
                            <?php wp_list_comments(); ?>


                            <div class="comments-template">
                                <?php comments_template(); ?>
                            </div><!-- .comments-template -->
                        </div><!-- post -->

                    <?php endwhile; ?>
                <?php endif; ?>

                </div><!-- #content -->

                <div id="sidebar"><?php dynamic_sidebar('sidebar-caseStudies'); ?></div><!-- #sidebar -->
            </div><!-- .row -->
        </div><!-- #right -->
    </div><!-- .interior-content -->
</div><!-- .container-fluid -->
