<?php
/* This be the news posts LANDING Page, not the single page, you got me?
================================================== */
?>

<?php get_header(); ?>

<?php
    echo headerImage();
?>

<div id="interior">
    <?php get_template_part( 'modules/page', 'newsLanding' ); ?>
</div>

<?php get_footer(); ?>