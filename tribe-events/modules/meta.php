<?php

    /**
     * Single Event Meta Template
     *
     * @package TribeEventsCalendar
     * @author Jimmy K. <jimmy@orbitmedia.com>
     */

    do_action('tribe_events_single_meta_before');
    do_action('tribe_events_single_event_meta_primary_section_start');
    tribe_get_template_part('modules/meta/details');
    do_action( 'tribe_events_single_event_meta_primary_section_end' );
    do_action( 'tribe_events_single_meta_after' );
