<?php get_header(); ?>

<?php get_template_part( 'modules/content', 'heroForm' ); ?>

<?php PageBlocks::output(); ?>

<?php get_template_part( 'modules/content', 'homeFeeds' ); ?>

<?php get_footer(); ?>
