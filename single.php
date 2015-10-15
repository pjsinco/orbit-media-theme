<?php
/* This be the Blog Posts DETAIL Page,you got me?
================================================== */
?>

<?php get_header(); ?>

<?php get_template_part( 'modules/content', 'interiorHero' ); ?>

<div id="interior">
    <?php
        if(get_post_type() == 'post') {
            //Blog
            get_template_part( 'modules/page', 'blogDetail' );

        } else {
            //WooCommerce
            get_template_part( 'modules/page', 'faq' );

        }
    ?>
</div>

<?php get_footer(); ?>
