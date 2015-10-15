<?php
/* This be the template to view custom taxonomies ,you got me?
================================================== */
?>

<?php get_header(); ?>

<?php
    echo headerImage();
?>

<div id="interior">
    <?php if(is_tax('white_paper_category')) {
        get_template_part('modules/page', 'whitePaperLanding');
    } elseif(is_tax('case_study_category')) {
        get_template_part('modules/page', 'caseStudyLanding');
    } elseif(is_tax('news_category')) {
        get_template_part('modules/page', 'newsLanding');
    } else {
        get_template_part('modules/page', 'blogLanding');
    } ?>
</div>

<?php get_footer(); ?>
