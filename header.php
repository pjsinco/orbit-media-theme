<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
if ( ! function_exists( '_wp_render_title_tag' ) ) {
    function theme_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'theme_slug_render_title' );
}
?>

<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
    /*
     *  Add this to support sites with sites with threaded comments enabled.
     */
    if ( is_singular() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    wp_get_archives('type=monthly&format=link');

    wp_head();
?>
</head>
<body <?php body_class( $class ); ?>>

<header class="outer-row">
    <nav class="navbar" role="navigation">
        <div class="container-fluid">

            <div id="searchform-desktop" class="collapse" aria-expanded="false">
                <div class="close-search" data-toggle="collapse" data-target="#searchform-desktop">close X</div>
                <?php get_search_form(); ?>
            </div> <!-- #searchform-desktop  -->

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#primaryNav">
                    <span class="sr-only"><?php _e('Toggle navigation'); ?></span>
                    <span class="text">Menu</span>
                    <span class="fa-bars fa"></span>
                </button>
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/images/aoa_logo.png" alt="<?php bloginfo('name'); ?>" /></a>
            </div>

            <!-- Primary Nav -->
            <div id="primaryNav" class="collapse">

                <div id="searchform-mobile" class="hidden-md hidden-lg">
                    <?php get_search_form( true ); ?>
                </div>

                <?php //wp_nav_menu( array( 'theme_location' => 'top-right-nav', 'container' => false, 'menu_class' => 'menu mobile-tr', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'walker' => new wp_bootstrap_navwalker() ) ); ?>
                <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => false, 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'walker' => new wp_bootstrap_navwalker() ) ); ?>

                <button class="search button hidden-xs hidden-sm" data-toggle="collapse" data-target="#searchform-desktop"><i class="fa fa-search"></i></button>

                <div class="close-mobile hidden-md hidden-lg" data-toggle="collapse" data-target="#primaryNav">
                    <i class="fa fa-angle-up"></i><span><i>Close</i></span><i class="fa fa-angle-up"></i>
                </div>

            </div> <!-- #primaryNav -->
        </div> <!-- .container-fluid -->
    </nav>
</header> <!--  .outer-row -->
