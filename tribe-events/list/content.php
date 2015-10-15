<?php

    /**
     * List View Content Template
     *
     * The content template for the list view. This template is also used for
     * the response that is returned on list view ajax requests.
     *
     * @package TribeEventsCalendar
     * @author Jimmy K. <jimmy@orbitmedia.com>
     */

    if (!defined('ABSPATH')) {
        // If absolute path isn't defined, exit.
        die('-1');
    }

    ?>

    <!-- #tribe-events-content -->
    <div id="tribe-events-content" class="tribe-events-list">

        <?php do_action( 'tribe_events_before_the_title' ); ?>
        <h1 class="tribe-events-page-title"><?php echo tribe_get_events_title() ?></h1>
        <?php do_action( 'tribe_events_after_the_title' ); ?>

        <?php tribe_events_the_notices(); ?>

        <?php /*
        <!-- List Header -->
        <?php do_action( 'tribe_events_before_header' ); ?>
        <div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
            <?php do_action( 'tribe_events_before_header_nav' ); ?>
            <?php tribe_get_template_part('list/nav', 'header'); ?>
            <?php do_action( 'tribe_events_after_header_nav' ); ?>
        </div><!-- #tribe-events-header -->
        <?php do_action( 'tribe_events_after_header' ); ?>
        */ ?>

        <?php if (have_posts()) : ?>
            <?php do_action('tribe_events_before_loop'); ?>
            <?php tribe_get_template_part('list/loop') ?>
            <?php do_action('tribe_events_after_loop'); ?>
        <?php endif; ?>

        <?php do_action( 'tribe_events_before_footer' ); ?>
        <!-- #tribe-events-footer -->
        <div id="tribe-events-footer">
            <?php do_action( 'tribe_events_before_footer_nav' ); ?>
            <?php tribe_get_template_part( 'list/nav', 'footer' ); ?>
            <?php do_action( 'tribe_events_after_footer_nav' ); ?>
        </div><!-- #tribe-events-footer -->
        <?php do_action( 'tribe_events_after_footer' ) ?>

    </div><!-- #tribe-events-content -->
