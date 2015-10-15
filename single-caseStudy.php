<?php
/* This be the Case Study DETAIL Page, you got me?
================================================== */
?>

<?php get_header(); ?>

<?php
    echo headerImage();
?>

<div id="interior">
    <?php get_template_part( 'modules/page', 'caseStudyDetail' ); ?>
</div>

<?php get_footer(); ?>
