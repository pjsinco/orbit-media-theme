<?php
/* This be the White Paper DETAIL Page, you got me?
================================================== */
?>

<?php get_header(); ?>

<?php
    echo headerImage();
?>

<div id="interior">
    <?php get_template_part( 'modules/page', 'whitePaperDetail' ); ?>
</div>

<?php get_footer(); ?>
