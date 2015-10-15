<?php

    /**
     * Single Event Template
     *
     * A single event. This displays the event title, description, meta, and
     * optionally, the Google map for the event.
     *
     * @package TribeEventsCalendar
     * @author Jimmy K. <jimmy@orbitmedia.com>
     */

    if (!defined('ABSPATH')) {
        // If absolute path isn't defined, exit.
        die('-1');
    }

    // Get the event id.
    $event_id = get_the_ID();

    // Get the body class.
    // Use "hasRightCol" because we're manually displaying the venue and map.
    $bodyClass = 'hasRightCol';

    ?>

    <!-- #interior -->
    <div id="interior">
        <div class="container-fluid">

            <div class="<?php echo $bodyClass; ?> interior-content">

                <div id="right">
                    <div class="row">

                        <div id="content" class="mainContent">

                            <div id="tribe-events-content" class="tribe-events-single vevent hentry">

                                <!-- tribe-events-back -->
                                <p class="tribe-events-back">
                                    <a href="<?php echo tribe_get_events_link() ?>"><?php _e('&lsaquo; Back to All Events', 'tribe-events-calendar') ?></a>
                                </p><!-- /tribe-events-back -->

                                <!-- tribe-notices -->
                                <div class="tribe-notices">
                                    <?php tribe_events_the_notices() ?>
                                </div><!-- /tribe-notices -->

                                <!-- tribe-events-single-event-title -->
                                <?php the_title('<h1 class="tribe-events-single-event-title summary entry-title">', '</h1>'); ?>
                                <!-- /tribe-events-single-event-title -->

                                <!-- tribe-events-schedule -->
                                <div class="tribe-events-schedule updated published tribe-clearfix">
                                    <?php echo tribe_events_event_schedule_details($event_id, '<h3>', '</h3>'); ?>
                                    <?php if (tribe_get_cost()) : ?>
                                        <span class="tribe-events-divider">|</span>
                                        <span class="tribe-events-cost">
                                            <?php echo tribe_get_cost(null, true) ?>
                                        </span>
                                    <?php endif; ?>
                                </div><!-- /tribe-events-schedule -->

                                <?php /*
                                <!-- #tribe-events-header -->
                                <div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
                                    <!-- Navigation -->
                                    <h3 class="tribe-events-visuallyhidden"><?php _e( 'Event Navigation', 'tribe-events-calendar' ) ?></h3>
                                    <ul class="tribe-events-sub-nav">
                                        <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
                                        <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
                                    </ul><!-- .tribe-events-sub-nav -->
                                </div><!-- /#tribe-events-header -->
                                */ ?>

                                <?php while ( have_posts() ) :  the_post(); ?>

                                    <!-- #post-x -->
                                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                        <?php /*
                                        <!-- Event featured image, but exclude link -->
                                        <?php echo tribe_event_featured_image($event_id, 'full', false); ?>
                                        */ ?>

                                        <?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
                                        <!-- tribe-events-single-event-description -->
                                        <div class="tribe-events-single-event-description tribe-events-content entry-content description">
                                            <?php the_content(); ?>
                                        </div><!-- /tribe-events-single-event-description -->
                                        <?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

                                        <?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
                                        <?php

                                            if (!apply_filters('tribe_events_single_event_meta_legacy_mode', false)) {
                                                tribe_get_template_part('modules/meta');
                                            }

                                        ?>
                                        <?php do_action('tribe_events_single_event_after_the_meta'); ?>

                                    </div><!-- #post-x -->

                                    <?php /*
                                    <?php if( get_post_type() == TribeEvents::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
                                    */ ?>

                                <?php endwhile; ?>

                                <?php /*
                                <!-- #tribe-events-footer -->
                                <div id="tribe-events-footer">
                                    <h3 class="tribe-events-visuallyhidden"><?php _e( 'Event Navigation', 'tribe-events-calendar' ) ?></h3>
                                    <ul class="tribe-events-sub-nav">
                                        <li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
                                        <li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
                                    </ul><!-- .tribe-events-sub-nav -->
                                </div><!-- /#tribe-events-footer -->
                                */ ?>

                            </div><!-- #tribe-events-content -->

                        </div> <!-- #content -->

                        <div id="sidebar">

                            <?php

                                // tribe_get_template_part('modules/meta/organizer');
                                tribe_get_template_part('modules/meta/venue');
                                tribe_get_template_part('modules/meta/map');

                            ?>

                        </div> <!-- /#sidebar -->

                    </div> <!--  .row -->
                </div> <!-- #right  -->

            </div><!-- /interior-container -->

        </div><!-- /container -->
    </div><!-- /#interior -->
