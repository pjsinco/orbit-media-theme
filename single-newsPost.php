<?php
/* This be the News Posts DETAIL Page, you got me?
================================================== */
?>

<?php get_header(); ?>

<?php
    echo headerImage();
?>

<div id="interior">
    <?php get_template_part( 'modules/page', 'newsDetail' ); ?>
</div>

<?php get_footer(); ?>
