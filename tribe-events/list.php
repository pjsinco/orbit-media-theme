<?php
    /**
     * List View Template
     *
     * The wrapper template for a list of events. This includes the Past Events and Upcoming Events views
     * as well as those same views filtered to a specific category.
     *
     * @package TribeEventsCalendar
     * @author Jimmy K. <jimmy@orbitmedia.com>
     */

    if (!defined('ABSPATH')) {
        // If absolute path isn't defined, exit.
        die('-1');
    }

    // Get the body class.
    $bodyClass = get_layout_class(is_active_sidebar('sidebar-events'));

    ?>

    <!-- #interior -->
    <div id="interior">
        <div class="container-fluid">

            <div class="<?php echo $bodyClass; ?> interior-content">

                <div id="right">
                    <div class="row">

                        <div id="content" class="mainContent facetwp-template">

                            <?php do_action( 'tribe_events_before_template' ); ?>
                            <?php /*
                            <!-- Tribe Bar -->
                            <?php tribe_get_template_part( 'modules/bar' ); ?>
                            */ ?>
                            <?php tribe_get_template_part( 'list/content' ); ?>
                            <div class="tribe-clear"></div>
                            <?php do_action( 'tribe_events_after_template' ) ?>

                        </div> <!-- #content -->

                        <div id="sidebar">
                            <?php dynamic_sidebar('sidebar-events'); ?>
                        </div><!-- /#sidebar -->

                    </div>
                </div> <!-- #right  -->

            </div> <!-- .interior-content -->

        </div> <!-- .container-fluid -->

    </div> <!-- #interior -->
