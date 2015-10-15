<?php
/* This be the Blog Posts LANDING Page, not the home page, you got me?
The Home page is in front-page.php
================================================== */
?>

<?php get_header(); ?>

<?php
    echo headerImage();
?>

<div id="interior">
    <?php get_template_part( 'modules/page', 'blogLanding' ); ?>
</div>

<?php get_footer(); ?>