<?php

    /**
     * Single Venue Template
     *
     * The template for a venue. By default it displays venue information and lists
     * events that occur at the specified venue.
     *
     * This view contains the filters required to create an effective single venue view.
     *
     * You can recreate an ENTIRELY new single venue view by doing a template override, and placing
     * a single-venue.php file in a tribe-events/pro/ directory within your theme directory, which
     * will override the /views/single-venue.php.
     *
     * You can use any or all filters included in this file or create your own filters in
     * your functions.php. In order to modify or extend a single filter, please see our
     * readme on templates hooks and filters (TO-DO)
     *
     * @package TribeEventsCalendarPro
     * @author Jimmy K. <jimmy@orbitmedia.com>
     */

    if (!defined('ABSPATH')) {
        // If absolute path isn't defined, exit.
        die('-1');
    }

    // Get the venue id.
    $venue_id = get_the_ID();

    // Get the body class.
    $bodyClass = get_layout_class(is_active_sidebar('events-sidebar'));

    ?>

    <!-- #interior -->
    <div id="interior">
        <div class="container-fluid">

            <div class="<?php echo $bodyClass; ?> interior-content">

                <div id="right">
                    <div class="row">

                        <div id="content" class="mainContent">

                            <?php while ( have_posts() ) : the_post(); ?>

                                <!-- tribe-events-venue -->
                                <div class="tribe-events-venue">

                                    <!-- tribe-events-back -->
                                    <p class="tribe-events-back">
                                        <a href="<?php echo tribe_get_events_link() ?>" rel="bookmark"><?php _e('&lsaquo; Back to All Events', 'tribe-events-calendar-pro'); ?></a>
                                    </p>

                                    <!-- tribe-events-venue-meta -->
                                    <div class="tribe-events-venue-meta vcard tribe-clearfix">

                                        <?php if ( tribe_embed_google_map() ) : ?>
                                            <!-- tribe-events-map-wrap -->
                                            <div class="tribe-events-map-wrap">
                                                <?php echo tribe_get_embedded_map( $venue_id, '100%', '280px' ); ?>
                                            </div><!-- /tribe-events-map-wrap -->
                                        <?php endif; ?>

                                        <?php do_action('tribe_events_single_venue_before_title') ?>
                                        <?php the_title('<h2 class="entry-title author fn org">','</h2>'); ?>
                                        <?php do_action('tribe_events_single_venue_after_title') ?>

                                        <!-- tribe-events-event-meta -->
                                        <div class="tribe-events-event-meta">
                                            <?php if ( tribe_show_google_map_link() ) : ?>
                                                <?php echo tribe_get_meta('tribe_event_venue_gmap_link'); ?>
                                            <?php endif; ?>
                                            <?php do_action('tribe_events_single_venue_before_the_meta') ?>
                                            <?php echo tribe_get_meta_group( 'tribe_event_venue' ) ?>
                                            <?php do_action('tribe_events_single_venue_after_the_meta') ?>
                                        </div><!-- /tribe-events-event-meta -->

                                        <?php if( get_the_content() ) : ?>
                                        <div class="tribe-venue-description tribe-events-content entry-content">
                                            <?php the_content(); ?>
                                        </div>
                                        <?php endif; ?>

                                        <?php /*
                                        <?php echo tribe_event_featured_image(null, 'full') ?>
                                        */ ?>

                                    </div><!-- /tribe-events-venue-meta -->

                                    <?php

                                        // Use the 'tribe_events_single_venue_posts_per_page' to filter the
                                        // number of events to display beneath the venue info on the venue page.

                                        do_action('tribe_events_single_venue_before_upcoming_events');
                                        echo tribe_include_view_list(array(
                                            'venue' => $venue_id,
                                            'eventDisplay' => 'upcoming',
                                            'posts_per_page' => apply_filters('tribe_events_single_venue_posts_per_page', 100),
                                        ));
                                        do_action('tribe_events_single_venue_after_upcoming_events');

                                    ?>

                                </div><!-- /tribe-events-venue -->

                            <?php endwhile; ?>

                        </div><!-- /mainContent -->

                        <div id="sidebar">
                            <?php dynamic_sidebar('sidebar-events'); ?>
                        </div> <!-- /#sidebar -->

                    </div> <!-- .row -->
                </div> <!-- #right  -->

            </div> <!-- /interior-content -->

        </div> <!-- .container-fluid -->
    </div> <!-- /#interior -->
