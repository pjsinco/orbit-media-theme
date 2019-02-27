<?php
// Register Custom Navigation Walker
require_once('wp_bootstrap_navwalker.php');

//Declare WooCommerce Support
// add_theme_support( 'woocommerce' );

//Declare Title Tag Support
add_theme_support( "title-tag" );

//Declare support for Feeds
add_theme_support( 'automatic-feed-links' );

//Tells WordPress to load the editor style css to WYSIWYGs.
add_editor_style();

//HTML5 Search form
add_theme_support( 'html5', array( 'search-form' ) );

//Declare default Content Width, because it makes WP happy.
if ( ! isset( $content_width ) ) $content_width = 800;

// Enable post thumbnails
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 520, 250, true );
add_image_size( 'blog-preview', 600, 380, true ); // Hard Crop Mode

// Adds in the ACF Options Page
if(function_exists('acf_add_options_page')) {
    acf_add_options_page();
    acf_add_options_sub_page('General');
    acf_add_options_sub_page('Social Media');
}

//Add Custom Background support. But it's hidden, so JK!
add_theme_support( 'custom-background' );

//Add Custom Header headers. (But not really)
add_theme_support( 'custom-header' );

//Whitelist our IP from WP Limit Login Attempts
function my_ip_whitelist($allow, $ip) {
    return ($ip == '72.54.189.186') ? true : $allow;
}
add_filter('limit_login_whitelist_ip', 'my_ip_whitelist', 10, 2);

//Removes items from the WP backend
function remove_menus(){
  remove_menu_page( 'link-manager.php' ); //Links
}
add_action( 'admin_menu', 'remove_menus' );

//Load PageBlocks & Slideshow if not in the WP Admin
if ( !is_admin() ) {

    /**
     * Page Blocks
     * @author Andi Ruggles <andi@orbitmedia.com>
     */
    require_once('class/PageBlocks.php');
    // $PageBlocks = new PageBlocks();

    /**
     * Slideshow/Carousel
     * @author Andi Ruggles <andi@orbitmedia.com>
     */
    require_once('class/Slideshow.php');
    $Slideshow = new Slideshow();

    /**
     * FAQs
     * @author Mike Biel <mike@orbitmedia.com>
     */
    require_once('class/FAQs.php');
    $FAQs = new FAQs();

}

/**
 * Menus
 * @author Andi Ruggles <andi@orbitmedia.com>
 */
require_once('class/Menus.php');
$Menu = new Menus();

//Add support for WordPress 3.0's custom menus
add_action( 'init', 'register_my_menu' );

//Register area for custom menu
function register_my_menu() {
    register_nav_menu( 'primary-menu', __( 'Primary Menu' ) );
    register_nav_menu( 'top-right-nav', __( 'Top Right Nav' ) );
    register_nav_menu( 'footer-menu', __( 'Footer Menu' ) );
    register_nav_menu( 'copyright-menu', __( 'Copyright Menu' ) );
}

//Some simple code for our widget-enabled sidebar
add_action( 'widgets_init', 'orbitmedia_slug_widgets_init' );
function orbitmedia_slug_widgets_init() {
    if ( function_exists('register_sidebar') ):

        register_sidebar(array(
            'id' => 'sidebar-1',
          'description' => __('This is a global sidebar that would appear on all standard pages unless replaced. Don\'t put anything on here!', 'orbit'),
            'before_widget' => '<!-- widget --><div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div><!-- /widget -->',
            'before_title' => '<h3 class="title">',
            'after_title' => '</h3>',
        ));

        $sidebars = array (
            'sidebar-blog' => 'Blog',
            'sidebar-faq' => 'FAQs',
            // 'sidebar-events' => 'Events',
            // 'sidebar-news' => 'News',
            // 'sidebar-caseStudies' => 'Case Studies',
            // 'sidebar-whitePapers' => 'White Papers',
            // 'sidebar-shop' => 'Shop',
        );

        foreach ( $sidebars as $id => $name):
        register_sidebar(
            array (
                'name'          => sprintf(__( '%s', 'orbit' ), $name),
                'id'            => $id,
                'description' => sprintf(__('The sidebar that appears on %s pages.', 'orbit'), $name),
                'before_widget' => '<!-- widget --><div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div><!-- /widget -->',
                'before_title' => '<h3 class="title">',
                'after_title' => '</h3>',
            ));
        endforeach;
    endif;
}

/**
 * Creates a Header Image
 * @author Andi Ruggles <andi@orbitmedia.com>
 */
function headerImage()
{

    global $post;

    //Gets the current page/post ID outside the loop.
    if ( !is_front_page() && is_home() ) {
        $record_id = get_option( 'page_for_posts' );
    } else {
        $record_id = get_queried_object_id();
    }

    if(get_field('header_image', $record_id) != '') {
        $image = get_field('header_image', $record_id);
        $headerImage = '
        <div class="headerImage">
            <img src="'.$image.'" />
            <div class="header-caption">
                <p>'.get_the_content().'</p>
            </div>
        </div>';
    }

    return $headerImage;
}

/**
 * Get the layout class (hasLeftAndRightCols, hasLeftCol, hasRightCol,
 * hasNoLeftOrRightCols).
 *
 * @param bool Is there a sidebar
 * @return string
 * @author  Andi Ruggles <andi@orbitmedia.com>
 * @author Jimmy K. <jimm@orbitmedia.com>
 */

function get_layout_class($sidebar = false, $leftPageData = false)
{

    //No sidebar & no left nav
    if ($sidebar == false && !$leftPageData ) {

        return "hasNoLeftOrRightCols";

    //No sidebar & left nav
    } elseif ($sidebar == false && $leftPageData != '' ) {

        return "hasLeftCol";

    //Sidebar & no left nav
    } elseif ($sidebar == true && !$leftPageData) {

        return "hasRightCol";
    }

    // We don't have left or right columns..
    return "hasLeftAndRightCols";

}

/**
 * Display the post content. Optionally allows post ID to be passed
 * @param int $id Optional. Post ID.
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool $stripteaser Optional. Strip teaser content before the more text. Default is false.
 */
function getContentByID( $post_id=0, $more_link_text = null, $stripteaser = false ){
    global $post;
    $post = get_post($post_id);
    setup_postdata( $post, $more_link_text, $stripteaser );
    the_content();
    wp_reset_postdata();
}

/**
 * Outputs the Current Page Title
 * @author Andi Ruggles <andi@orbitmedia.com>
 * @author Mark Furrow
 */
function pageTitle( $id = '' )
{

    $record_id = $id;

    if ( is_tax() ) :
            return '<h1>'. single_term_title( "", false ) .'</h1>';
    else :
        // If there's a title for pages, use that
        if ( get_field( 'title', $record_id ) != '' ) {

            return '<h1>'. get_field( 'title', $record_id ) .'</h1>';

        // Otherwise, just use the name
        } else {
            return '<h1>'. get_the_title( $record_id ) .'</h1>';
        }

    endif;

}

/**
 * Enqueue the Forms & Reports JS scripts
 * @author Andi Ruggles <andi@orbitmedia.com>
 */
function orbit_enqueue_scripts()
{
    $record_id = get_queried_object_id();
    if ( !is_admin() ) {

        // jQuery
        if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
            wp_register_script( 'jquery', '//code.jquery.com/jquery.js', '', true );
            wp_enqueue_script( 'jquery' );
        }

        // SolarBox
        if ( ! wp_script_is( 'oms_solarbox', 'enqueued' ) ) {
            wp_register_script( 'oms_solarbox', get_stylesheet_directory_uri() .'/js/jquery.solarbox.js', array('jquery') );
            wp_enqueue_script( 'oms_solarbox', get_stylesheet_directory_uri() .'/js/jquery.solarbox.js' );
        }

        // Custom
        wp_enqueue_script(
            'oms_custom',
            get_stylesheet_directory_uri() . '/js/custom.js',
            array( 'jquery', 'oms_solarbox' ),
            null,
            true
        );

        wp_enqueue_script(
            'forms', get_stylesheet_directory_uri() . '/js/forms.js', array( 'jquery' ), '', true
        );

        wp_enqueue_style( 
          'layout', 
          get_stylesheet_directory_uri().'/css/layout.css',
          array(),
          filemtime( get_template_directory() . '/css/layout.css' )
        );

        wp_enqueue_style( 
          'default', 
          get_stylesheet_directory_uri().'/css/default.css',
          array(),
          filemtime( get_template_directory() . '/css/default.css' )
        );
    }
}

add_action( 'wp_enqueue_scripts', 'orbit_enqueue_scripts' );



/**
 *  Trim excerpts by word count instead of letter count.
 *  @see add_filter()
 *  @author Andi Ruggles
 */
function oms_improvedTrimExcerpt($sValue)
{

    global $post;

    if (empty($sValue)) {

        // The number of words to truncate to..
        $iExcerptLength = 20;

        // The Read More text..
        $sReadMoreText = "Read&nbsp;More&nbsp;&rsaquo;";

        $sValue = get_the_content('');
        $sValue = apply_filters('the_content', $sValue);
        $sValue = strip_shortcodes($sValue);
        $sValue = str_replace(']]>', ']]&gt;', $sValue);
        $sValue = preg_replace('@<script[^>]*?>.*?</script>@si', '', $sValue);
        $sValue = preg_replace('#<p class="wp-caption-text">(.*?)</p>#', '', $sValue);
        $sValue = strip_tags($sValue, '<p><strong>');

        // Get the words..
        $aWords = explode(' ', $sValue, $iExcerptLength + 1);

        if (count($aWords) > $iExcerptLength) {

            array_pop($aWords);

            // Put it back together..
            $sValue = implode(' ', $aWords);
            $sValue = $sValue.'&hellip;&nbsp;<a class="readMore" href="'.get_permalink().'">Read More&nbsp;&rsaquo;</a>';

        }

    }

    return $sValue;
}
// Remove the default excerpt filter..
remove_filter('get_the_excerpt', 'wp_trim_excerpt');

// Use our excerpt filter instead..
add_filter('get_the_excerpt', 'oms_improvedTrimExcerpt');

/**
 * Fixes it so empty searches still hit the search results page.
 * @author Andi Ruggles <andi@orbitmedia.com>
 */
function fix_empty_search ($query){
    global $wp_query;
    if (isset($_GET['s']) && empty($_GET['s'])){
        $wp_query->is_search=true;
    }
    return $query;
}
add_action('pre_get_posts','fix_empty_search');

/**
 * Adds additional fields to the Relevanssi excerpt
 * @author Andi Ruggles <andi@orbitmedia.com>
 * @author Jimmy K. <jimmy@orbitmedia.com>
 * @param  string $content Current excerpt returned from Relevanssi
 * @param  obj $post $post object
 * @param  string $query current search query
 * @return string updated excerpt with additional fields appended
 */
function excerpt_function($content, $post, $query) {

    //We need to get all the custom fields
    global $wpdb;
    $fields = $wpdb->get_col("SELECT DISTINCT(meta_key) FROM $wpdb->postmeta");

    //Add the home featured content, the old method of doing page blocks is here as well, and the SEO Ultimate Title
    $homeFeaturedContent = preg_grep('/^featured_content_[0-9]+_content$/', $fields);
    $blocks = preg_grep('/^text_(left|right|middle)$/', $fields);
    $meta = preg_grep('/^_su_title/', $fields);

    $searchFields = array_merge($homeFeaturedContent, $meta, $blocks);

    foreach($searchFields as $key => $field){
        $field_value = get_post_meta($post->ID, $field, TRUE);
        $content .= ' ' . ( is_array($field_value) ? implode(' ', $field_value) : $field_value );
    }

    return $content;
}
add_filter('relevanssi_pre_excerpt_content', 'excerpt_function', 10, 3);

/**
 * Gets the Content Fields of Page Blocks so that
 * we can add them to the Relevannsi search index.
 * @author Andi Ruggles <andi@orbitmedia.com>, Jimmy K. <jimmy@orbitmedia.com>
 * @param  string $content Currently, this is blank.
 * @param  object $post    This is the post object
 * @return string additional post content to be indexed by Relevanssi
 * If fields are added here, you MUST reindex in Settings -> Relevanssi
 * Erase the index and re-index.
 */
function getPageBlockContent($content, $post)
{
    $pageBlockJoin = get_field('page_blocks_join', $post->ID);

    if( $pageBlockJoin ):

        //List all the custom fields we want to search through
        $fieldsToAdd = array('header', 'text_left', 'text_middle', 'text_right');

        foreach( $pageBlockJoin as $p ):
            foreach($fieldsToAdd as $field):
                $content .= get_field($field,$p->ID);
            endforeach;
        endforeach;
    endif;
    return $content;
}
add_filter('relevanssi_content_to_index', 'getPageBlockContent', 10, 3);

// To give Editors access to the ALL Forms menu
function my_custom_change_ninja_forms_all_forms_capabilities_filter( $capabilities ) {
    $capabilities = "edit_pages";
    return $capabilities;
}
add_filter( 'ninja_forms_admin_parent_menu_capabilities', 'my_custom_change_ninja_forms_all_forms_capabilities_filter' );
add_filter( 'ninja_forms_admin_all_forms_capabilities', 'my_custom_change_ninja_forms_all_forms_capabilities_filter' );
// To give Editors access to ADD New Forms
function my_custom_change_ninja_forms_add_new_capabilities_filter( $capabilities ) {
    $capabilities = "edit_pages";
    return $capabilities;
}
add_filter( 'ninja_forms_admin_parent_menu_capabilities', 'my_custom_change_ninja_forms_add_new_capabilities_filter' );
add_filter( 'ninja_forms_admin_add_new_capabilities', 'my_custom_change_ninja_forms_add_new_capabilities_filter' );

/*  To give Editors access to the Submissions - Simply replace 'edit_posts'
    in the code snippet below with the capability
    that you would like to attach the ability to view/edit submissions to.
    Please note that all three filters are needed to
    provide proper submission viewing/editing on the backend!
*/

function nf_subs_capabilities( $cap ) {
    return 'edit_posts';
}
add_filter( 'ninja_forms_admin_submissions_capabilities', 'nf_subs_capabilities' );
add_filter( 'ninja_forms_admin_parent_menu_capabilities', 'nf_subs_capabilities' );
add_filter( 'ninja_forms_admin_menu_capabilities', 'nf_subs_capabilities' );

// To give Editors access to the Inport/Export Options
function my_custom_change_ninja_forms_import_export_capabilities_filter( $capabilities ) {
    $capabilities = "edit_pages";
    return $capabilities;
}
add_filter( 'ninja_forms_admin_parent_menu_capabilities', 'my_custom_change_ninja_forms_import_export_capabilities_filter' );
add_filter( 'ninja_forms_admin_import_export_capabilities', 'my_custom_change_ninja_forms_import_export_capabilities_filter' );

// To give Editors access to the the Settings page
function my_custom_change_ninja_forms_settings_capabilities_filter( $capabilities ) {
    $capabilities = "edit_pages";
    return $capabilities;
}
add_filter( 'ninja_forms_admin_parent_menu_capabilities', 'my_custom_change_ninja_forms_settings_capabilities_filter' );
add_filter( 'ninja_forms_admin_settings_capabilities', 'my_custom_change_ninja_forms_settings_capabilities_filter' );


//Remove the WooCommerce Content Wrappers because we have our own.
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
    if ( is_product_category() ){
        global $wp_query;
        $cat = $wp_query->get_queried_object();
        $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
        $image = wp_get_attachment_url( $thumbnail_id );
        if ( $image ) {
            echo '<img src="' . $image . '" alt="" />';
        }
    }
}

/**
 * Get submenu items from a WordPress menu based on parent or sibling
 *
 * filter_hook function to react on sub_menu flag
 *
 * @param  array  $sorted_menu_items The menu items, sorted by each menu item's menu order.
 * @param  object $args              An object containing wp_nav_menu() arguments.
 * @return array                     Array of submenu page objects
 * @author Mark Furrow <mark@orbitmedia.com>
 */
function oms_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {

    if ( ! empty( $args->sub_menu ) ) {

        $root_id = 0;

        // find the current menu item
        foreach ( $sorted_menu_items as $menu_item ) {
            if ( $menu_item->current ) {
                // set the root id based on whether the current menu item has a parent or not
                $root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
                break;
            }
        }

        // find the top level parent
        if ( ! isset( $args->direct_parent ) ) {
          $prev_root_id = $root_id;
          while ( $prev_root_id != 0 ) {
            foreach ( $sorted_menu_items as $menu_item ) {
              if ( $menu_item->ID == $prev_root_id ) {
                $prev_root_id = $menu_item->menu_item_parent;
                // don't set the root_id to 0 if we've reached the top of the menu
                if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
                break;
              }
            }
          }
        }

        // find the top level parent
        if ( ! isset( $args->direct_parent ) ) {
            $prev_root_id = $root_id;
            while ( $prev_root_id != 0 ) {
                foreach ( $sorted_menu_items as $menu_item ) {
                    if ( $menu_item->ID == $prev_root_id ) {
                        $prev_root_id = $menu_item->menu_item_parent;
                        // don't set the root_id to 0 if we've reached the top of the menu
                        if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
                        break;
                    }
                }
            }
        }

        $menu_item_parents = array();
        foreach ( $sorted_menu_items as $key => $item ) {
            // init menu_item_parents
            if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;

            if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
                // part of sub-tree: keep!
                $menu_item_parents[] = $item->ID;
            } else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
                // not part of sub-tree: away with it!
                unset( $sorted_menu_items[$key] );
            }
        }

        return $sorted_menu_items;

    } else {

        return $sorted_menu_items;
    }
}
add_filter( 'wp_nav_menu_objects', 'oms_wp_nav_menu_objects_sub_menu', 10, 2 );


// Outputs the Mini Cart on the initial page load.
function oms_woo_output_minicart(){
    ob_start();
    oms_format_woo_minicart();
    $x = ob_get_contents();
    ob_end_clean();
    return $x;
}

// Formats the Minicart for use by the initial output and the AJAX reload.
function oms_format_woo_minicart() {
    global $woocommerce;
    ?><a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><i class="fa fa-shopping-cart"></i> <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> <?php echo '('.$woocommerce->cart->get_cart_total().')'; ?></a>

    <?php
}

// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
function woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    ob_start();
    oms_format_woo_minicart();
    $fragments['a.cart-contents'] = ob_get_clean();
    return $fragments;
}
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

/**
 * Creates the Team Bios Custom Post Type
 * @author Andi Ruggles <andi@orbitmedia.com>
 */
// add_action( 'init', 'register_cpt_team_bio' );

function register_cpt_team_bio() {

    $labels = array(
        'name' => _x( 'Team Bios', 'team_bio' ),
        'singular_name' => _x( 'Team Bio', 'team_bio' ),
        'add_new' => _x( 'Add New', 'team_bio' ),
        'add_new_item' => _x( 'Add New Bio', 'team_bio' ),
        'edit_item' => _x( 'Edit Bio', 'team_bio' ),
        'new_item' => _x( 'New Bio', 'team_bio' ),
        'view_item' => _x( 'View Bio', 'team_bio' ),
        'search_items' => _x( 'Search Bios', 'team_bio' ),
        'not_found' => _x( 'No bios found', 'team_bio' ),
        'not_found_in_trash' => _x( 'No bios found in Trash', 'team_bio' ),
        'parent_item_colon' => _x( 'Parent Team Bio:', 'team_bio' ),
        'menu_name' => _x( 'Team Bios', 'team_bio' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Bios about your team',
        'supports' => array( 'title', 'editor', 'custom-fields', 'revisions' ),

        'public' => true,
        'menu_icon' => 'dashicons-businessman',
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,

        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'team_bio', $args );
}

// Register Custom Post Type
function createPageBlocks() {

    $labels = array(
        'name'                => _x( 'Page Blocks', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Page Block', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Page Blocks', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
        'all_items'           => __( 'All Page Blocks', 'text_domain' ),
        'view_item'           => __( 'View Block', 'text_domain' ),
        'add_new_item'        => __( 'Add New Block', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'edit_item'           => __( 'Edit Block', 'text_domain' ),
        'update_item'         => __( 'Update Block', 'text_domain' ),
        'search_items'        => __( 'Search Page Blocks', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'pageBlock', 'text_domain' ),
        'description'         => __( 'Post type for creating custom page blocks', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'revisions', ),
        'hierarchical'        => false,
        'public'              => true,
        'menu_icon'           => 'dashicons-tagcloud',
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 20,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'pageBlock', $args );

}

// Hook into the 'init' action
add_action( 'init', 'createPageBlocks', 0 );


/*
 *  NEW CUSTOM POST TYPES AND TAXONOMIES:
 *  News, Case Studies and White Papers
 *  Added By Chris LaFrombois
 *
//*/

// Register Custom Taxonomy
function news_category() {

    $labels = array(
        'name'                       => _x( 'News Categories', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'News Category', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'News Categories', 'text_domain' ),
        'all_items'                  => __( 'All News Categories', 'text_domain' ),
        'parent_item'                => __( 'Parent News Category', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent News Category:', 'text_domain' ),
        'new_item_name'              => __( 'New News Category', 'text_domain' ),
        'add_new_item'               => __( 'Add New News Category', 'text_domain' ),
        'edit_item'                  => __( 'Edit News Category', 'text_domain' ),
        'update_item'                => __( 'Update News Category', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate News Categories with commas', 'text_domain' ),
        'search_items'               => __( 'Search News Categories', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove News Categories', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used News Categories', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'news_category', array( 'newsPost' ), $args );

}

// Hook into the 'init' action
// add_action( 'init', 'news_category', 0 );


// Register Custom Post Type
function createNewsPost() {

    $labels = array(
        'name'                => _x( 'News', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'News', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'News', 'text_domain' ),
        'parent_item_colon'   => __( 'News Post', 'text_domain' ),
        'all_items'           => __( 'All News Posts', 'text_domain' ),
        'view_item'           => __( 'View News Post', 'text_domain' ),
        'add_new_item'        => __( 'Add News Post', 'text_domain' ),
        'add_new'             => __( 'Add News', 'text_domain' ),
        'edit_item'           => __( 'Edit News Post', 'text_domain' ),
        'update_item'         => __( 'Update News Post', 'text_domain' ),
        'search_items'        => __( 'Search News Post', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'newsPost', 'text_domain' ),
        'description'         => __( 'Post type for creating news items', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
        'taxonomies'          => array( 'news_category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-format-aside',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'rewrite'             => array('slug'=>'news_post'),
    );
    register_post_type( 'newsPost', $args );

}

// Hook into the 'init' action
// add_action( 'init', 'createNewsPost', 0 );


// Register Custom Taxonomy
function case_study_category() {

    $labels = array(
        'name'                       => _x( 'Case Study Categories', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Case Study Category', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Case Study Categories', 'text_domain' ),
        'all_items'                  => __( 'All Case Study Categories', 'text_domain' ),
        'parent_item'                => __( 'Parent Case Study Category', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Case Study Category:', 'text_domain' ),
        'new_item_name'              => __( 'Case Study Category', 'text_domain' ),
        'add_new_item'               => __( 'Add New Case Study Category', 'text_domain' ),
        'edit_item'                  => __( 'Edit Case Study Category', 'text_domain' ),
        'update_item'                => __( 'Update Case Study Category', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate Case Study Categories with commas', 'text_domain' ),
        'search_items'               => __( 'Search Case Study Categories', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove Case Study Category', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used Case Study Categories', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'case_study_category', array( 'caseStudy' ), $args );

}

// Hook into the 'init' action
// add_action( 'init', 'case_study_category', 0 );


// Register Custom Post Type
function createCaseStudy() {

    $labels = array(
        'name'                => _x( 'Case Studies', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Case Study', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Case Studies', 'text_domain' ),
        'parent_item_colon'   => __( 'Case Study Post', 'text_domain' ),
        'all_items'           => __( 'All Case Studies', 'text_domain' ),
        'view_item'           => __( 'View Case Study', 'text_domain' ),
        'add_new_item'        => __( 'Add Case Study', 'text_domain' ),
        'add_new'             => __( 'Add Case Study', 'text_domain' ),
        'edit_item'           => __( 'Edit Case Study', 'text_domain' ),
        'update_item'         => __( 'Update Case Study', 'text_domain' ),
        'search_items'        => __( 'Search Case Study', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'caseStudy', 'text_domain' ),
        'description'         => __( 'Post type for creating case study posts', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
        'taxonomies'          => array( 'case_study_category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-analytics',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'rewrite'             => array('slug'=>'case-studies',),
    );
    register_post_type( 'caseStudy', $args );

}

// Hook into the 'init' action
// add_action( 'init', 'createCaseStudy', 0 );


// Register Custom Taxonomy
function white_paper_category() {

    $labels = array(
        'name'                       => _x( 'White Paper Categories', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'White Paper Category', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'White Paper Categories', 'text_domain' ),
        'all_items'                  => __( 'All White Paper Categories', 'text_domain' ),
        'parent_item'                => __( 'Parent White Paper Category', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent White Paper Category:', 'text_domain' ),
        'new_item_name'              => __( 'White Paper Category', 'text_domain' ),
        'add_new_item'               => __( 'Add New White Paper Category', 'text_domain' ),
        'edit_item'                  => __( 'Edit White Paper Category', 'text_domain' ),
        'update_item'                => __( 'Update White Paper Category', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate White Paper Categories with commas', 'text_domain' ),
        'search_items'               => __( 'Search White Paper Categories', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove White Paper Category', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used White Paper Categories', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'white_paper_category', array( 'whitePaper' ), $args );

}

// Hook into the 'init' action
// add_action( 'init', 'white_paper_category', 0 );



// Register Custom Post Type
function createWhitePaper() {

    $labels = array(
        'name'                => _x( 'White Papers', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'White Paper', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'White Papers', 'text_domain' ),
        'parent_item_colon'   => __( 'White Paper', 'text_domain' ),
        'all_items'           => __( 'All White Papers', 'text_domain' ),
        'view_item'           => __( 'View White Paper', 'text_domain' ),
        'add_new_item'        => __( 'Add White Paper', 'text_domain' ),
        'add_new'             => __( 'Add White Paper', 'text_domain' ),
        'edit_item'           => __( 'Edit White Paper', 'text_domain' ),
        'update_item'         => __( 'Update White Paper', 'text_domain' ),
        'search_items'        => __( 'Search White Paper', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'whitePaper', 'text_domain' ),
        'description'         => __( 'Post type for creating white paper posts', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
        'taxonomies'          => array( 'white_paper_category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-chart-area',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'rewrite'             => array('slug'=>'white-papers',),
    );
    register_post_type( 'whitePaper', $args );

}

// Hook into the 'init' action
// add_action( 'init', 'createWhitePaper', 0 );

// Register Custom Post Type
function createFAQ() {

    $labels = array(
        'name'                => _x( 'FAQs', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'FAQs', 'text_domain' ),
        'parent_item_colon'   => __( 'FAQ', 'text_domain' ),
        'all_items'           => __( 'All FAQs', 'text_domain' ),
        'view_item'           => __( 'View FAQ', 'text_domain' ),
        'add_new_item'        => __( 'Add FAQ', 'text_domain' ),
        'add_new'             => __( 'Add FAQ', 'text_domain' ),
        'edit_item'           => __( 'Edit FAQ', 'text_domain' ),
        'update_item'         => __( 'Update FAQ', 'text_domain' ),
        'search_items'        => __( 'Search FAQ', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'faq', 'text_domain' ),
        'description'         => __( 'Post type for creating FAQ blocks', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'custom-fields' ),
        'taxonomies'          => array( 'faq_category', 'post_tag' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 7,
        'menu_icon'           => 'dashicons-info',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'rewrite'             => array('slug'=>'faq'),
    );
    register_post_type( 'FAQ', $args );

}

// Hook into the 'init' action
add_action( 'init', 'createFAQ', 0 );


/**
 *  NEW USER ROLE: Client
 *  Added By Mike Biel
 *  Permissions decided by Jimmy Klatt
 *  TO UPDATE THE PERMISSIONS UNCOMMENT THIS BELOW AND REFRESH, THEN RECOMMENT
 *  remove_role( 'client_admin' );
 */
add_role('client_admin', 'Client Admin', array(
    'activate_plugins' => false,
    'delete_others_pages' => true,
    'delete_others_posts' => true,
    'delete_pages' => true,
    'delete_plugins' => false,
    'delete_posts' => true,
    'delete_private_pages' => true,
    'delete_private_posts' => true,
    'delete_published_pages' => true,
    'delete_published_posts' => true,
    'edit_dashboard' => true,
    'edit_files' => false,
    'edit_others_pages' => true,
    'edit_others_posts' => true,
    'edit_pages' => true,
    'edit_posts' => true,
    'edit_private_pages' => true,
    'edit_private_posts' => true,
    'edit_published_pages' => true,
    'edit_published_posts' => true,
    'edit_theme_options' => true,
    'export' => true,
    'import' => true,
    'list_users' => true,
    'manage_categories' => true,
    'manage_links' => true,
    'manage_options' => true,
    'moderate_comments' => true,
    'promote_users' => true,
    'publish_pages' => true,
    'publish_posts' => true,
    'read_private_pages' => true,
    'read_private_posts' => true,
    'read' => true,
    'remove_users' => true,
    'switch_themes' => false,
    'upload_files' => true,
    'update_core' => false,
    'update_plugins' => false,
    'update_themes' => false,
    'install_plugins' => false,
    'install_themes' => false,
    'delete_themes' => false,
    'edit_plugins' => false,
    'edit_themes' => false,
    'edit_users' => true,
    'create_users' => true,
    'delete_users' => true,
    'unfiltered_html' => true
));



/* AOA */



/**
 * Add Custom Style Formats to WYSIWIG
 *
 * @param  array $settings
 * @return array
 * @author Mark Furrow <mark@orbitmedia.com>
 */
function oms_mce_before_init( $settings ) {

    $style_formats = array(
        array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button'
        ),
        array(
            'title' => 'Read More',
            'selector' => 'a',
            'classes' => 'readmore'
        )
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}
add_filter( 'tiny_mce_before_init', 'oms_mce_before_init' );


/**
 * Remove WYSIWYG Editor from Home Page
 *
 * @author Mark Furrow <mark@orbitmedia.com>
 */
function remove_editor_init() {
    // If not in the admin, return.
    if ( ! is_admin() ) {
       return;
    }

    // Get the post ID on edit post with filter_input super global inspection.
    $current_post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );
    // Get the post ID on update post with filter_input super global inspection.
    $update_post_id = filter_input( INPUT_POST, 'post_ID', FILTER_SANITIZE_NUMBER_INT );

    // Check to see if the post ID is set, else return.
    if ( isset( $current_post_id ) ) {
       $post_id = absint( $current_post_id );
    } else if ( isset( $update_post_id ) ) {
       $post_id = absint( $update_post_id );
    } else {
       return;
    }

    // Don't do anything unless there is a post_id.
    if ( isset( $post_id ) ) {

       // Get the template of the current post.
       $template_file = get_post_meta( $post_id, '_wp_page_template', true );

       // Example of removing page editor for page-your-template.php template.
       if (  'page-your-template.php' === $template_file ) {
           remove_post_type_support( 'page', 'editor' );
           // Other features can also be removed in addition to the editor. See: https://codex.wordpress.org/Function_Reference/remove_post_type_support.
       }

        if ( 18 === $post_id ) {
            remove_post_type_support( 'page', 'editor' );
        }
    }
}
add_action( 'init', 'remove_editor_init' );

/**
 * Replaces the default WordPress comment list with a self laid out one.
 * @param  arr $comment All the comment information
 * @param  arr $args Array of custom arguments - allow children?, etc.
 * Full list of args here: http://codex.wordpress.org/Function_Reference/wp_list_comments
 * @param  int $depth How many levels of comments do we want to allow? By default, this will pull from WordPress's settings
 * @return string single comment output (will be looped through)
 */
function mytheme_comment( $comment, $args, $depth )
{
    $GLOBALS['comment'] = $comment;
    switch ($comment->comment_type) :
        case 'pingback' :
        case 'trackback' :
            break;
        default :
            // Proceed with normal comments.
            global $post; ?>

            <li class="comment comment-media" id="li-comment-<?php comment_ID(); ?>">

                <a href="<?php echo $comment->comment_author_url;?>" class="gravatar">
                    <?php echo get_avatar($comment, 200); ?>
                </a>

                <div class="meta">
                    <cite><?php echo get_comment_author_link(); ?> says:</cite>
                    <time><?php echo get_comment_date('M j, Y'); ?></time>
                </div>

                <div class="comment-body">
                    <?php if ( '0' == $comment->comment_approved ) : ?>
                        <p class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.','bootstrapwp'); ?></p>
                    <?php endif; ?>

                    <?php comment_text(); ?>
                </div>

            <?php
            break;
    endswitch;
}

function elit_enqueue_scripts()
{
  wp_register_script( 'fitvids', 
    get_template_directory_uri() . '/js/jquery.fitvids.js', 
    array( 'jquery' ), false, true
  );
}
add_action('wp_enqueue_scripts' , 'elit_enqueue_scripts');

/**
 * Add our fitvids loader
 *
 * http://fitvidsjs.com/
 */
function elit_add_fitvids_script() {
  $output = '<script>' . PHP_EOL;
  $output .= 'jQuery(document).ready(function() {' . PHP_EOL;
  $output .= "  jQuery('.elit-video').fitVids();" . PHP_EOL;
  $output .= "});";
  $output .= '</script>' . PHP_EOL;

  echo $output;
}

function elit_story_video_shortcode($atts, $content = null ) {
  // we're going to need fitvids
  wp_enqueue_script('fitvids');
  add_action( 'wp_footer' , 'elit_add_fitvids_script', 10 );

  $a = shortcode_atts(
    array(
      'embed' => '',
    ), $atts
  );
  $markup  = "<figure class='image image--secondary elit-video' id='video'>";
  $markup .= $a['embed'];
  $markup .= '</figure>';
  return $markup;
}
add_shortcode('story-video', 'elit_story_video_shortcode' );

function elit_related_shortcode($atts, $content = null) {
  $a = shortcode_atts(
    array(
      'id' => '',
    ), $atts
  );

  $post = get_post( $a['id'] );

  // make sure the related post is published
  if ( !$post || $post->post_status != 'publish') {
    return $post; 
  }

  // build up our string to output
  $output  = '<div class="story__box">';
  $output .= '<div class="related">';
  $output .= '<div class="related__title">Related</div>';

  $thumb_id = null;

  if ( has_post_thumbnail( $post->ID ) ) {
    $thumb_id = get_post_thumbnail_id( $post->ID );
  } else {
    $meta = get_post_meta( $post->ID );
    $thumb_id = $meta['elit_thumb'][0];
  }
  
  $thumb = get_post( $thumb_id );

  if ( $thumb_id )  {
    $thumb_url = wp_get_attachment_thumb_url( $thumb_id );
    $output .= '<img class="related__img" src="' . $thumb_url . '" ';
    $output .= 'alt="' . $thumb->post_content . '" width="140" />';
  }

  $output .= '<div class="related__body">';
  $output .= '<h3 class="related__head">';
  $output .= '<a href="' . get_permalink( $post->ID ) . '" ';
  $output .= 'class="related__link">' . $post->post_title . '</a>';
  $output .= '</h3>';
  $output .= '</div>';
  $output .= '</div>';
  $output .= '</div>';
  
  return $output;
}

add_shortcode('related', 'elit_related_shortcode' );

/**
 * Source: http://wordpress.stackexchange.com/questions/16070/
 *     how-to-highlight-search-terms-without-plugin
 *
 */
function elit_highlighted_search_excerpt() {
  $excerpt = strip_tags(get_the_excerpt());
  $search_query = get_search_query();
  
  // if search term is in quotes, keep it together
  if (preg_match('/"|&quot;/', $search_query) === 1) {
    $search_pattern = str_replace(array("&quot;", '"'), "", $search_query);
    $re = "/($search_pattern)/i";
  } else {
    $search_pattern = str_replace(array("&quot;", '"'), "", $search_query);
    $re = '/(' . implode('|', explode(' ', $search_pattern)) . ')/i';
  }
  return preg_replace($re, '<span class="highlight">$1</span>', $excerpt);
}

/**
 * Source: http://wordpress.stackexchange.com/questions/16070/
 *     how-to-highlight-search-terms-without-plugin
 *
 */
function elit_highlight_search($text) {
  if (in_the_loop() && is_search() && !is_admin()) {
    $search_terms = get_query_var('s');

    if (preg_match('/"|&quot;/', $search_terms) === 1) {
      $search_pattern = str_replace(array("&quot;", '"'), "", $search_terms);
      $re = '\'(?!((<.*?)|(<a.*?)))(' . 
        $search_pattern .  
        ')(?!(([^<>]*?)>)|([^>]*?</a>))\'iu';
    } else {
      $keys = explode(" ", $search_terms);
      $keys = array_filter($keys);

      $re = '\'(?!((<.*?)|(<a.*?)))(' . 
        implode('|', $keys) . 
        ')(?!(([^<>]*?)>)|([^>]*?</a>))\'iu';
    }

    $text = preg_replace($re, '<span class="highlight">\0</span>', strip_tags($text));

  }
  return $text;
}
add_filter('the_title', 'elit_highlight_search');
add_filter('the_excerpt', 'elit_highlight_search');

function elit_format_document_title_on_posts( $title ) {
  if ( ! is_single() ) {
    return; 
  }

  global $post;
  $post->post_title;

  return sprintf( '%s - %s', $post->post_title, get_bloginfo( 'name' ) );
}
add_filter( 'pre_get_document_title', 'elit_format_document_title_on_posts' );


function elit_dtd_settings() {

  register_setting( 'meetdtd', 'meetdtd_widget_id' );

  add_settings_section(
    'meetdtd_widget_id_section',
    'Meet Doctors That DO',
    'meetdtd_widget_id_section_cb',
    'meetdtd'
  );

  add_settings_field(
    'meetdtd_field_input',
    'Widget ID',
    'meetdtd_field_input_cb',
    'meetdtd',
    'meetdtd_widget_id_section'
  );

}
add_action('admin_init', 'elit_dtd_settings');

function meetdtd_widget_id_section_cb( $args ) {
  echo '<h4>The ID of the OMS Persistent Widget that displays the Meet Doctors That DO grid</h4>';
}

function meetdtd_field_input_cb() {
  $setting = get_option('meetdtd_widget_id');
  ?>
  <input type="text" name="meetdtd_widget_id" value="<?php echo (isset( $setting ) ? esc_attr( $setting ) : ''); ?>"> 
  <?php
}

function meetdtd_widget_id_page() {

  add_options_page(  
    'Meet Doctors That DO',
    'Meet Doctors That DO Options',
    'manage_options',
    'meetdtd',
    'meetdtd_widget_id_page_html'
  );

}
add_action('admin_menu' , 'meetdtd_widget_id_page');

function meetdtd_widget_id_page_html() {

  if ( !current_user_can( 'manage_options' ) ) {
    return;
  }

  ?>
  <div class="wrap">
    <h1><?php esc_html( get_admin_page_title() ); ?></h1>

    <form method="POST" action="options.php">
      <?php
        settings_fields('meetdtd');
        do_settings_sections('meetdtd');
        submit_button('Save');
      ?>
    </form>
  <div class="wrap">
  
  <?php
}


/**
 * One-off short-code to display *one* particular OMS Persistent Widget:
 *   The one with the brady-bunch-style "Meet Doctors That DO" content.
 *
 */
function elit_meet_dtd_shortcode( $atts ) {


  $meetdtd_widget_id = get_option( 'meetdtd_widget_id' );

  extract(
    shortcode_atts(
      array(
        'title' => '',
        'disabled_index' => ''
      ), $atts
    )
  );


  $fields = get_fields($meetdtd_widget_id);

  $html = "<h4 class='bb_square__title'>$title</h4>";
  $html .= $fields['oms_open_content'];

  if ( !empty( $disabled_index ) ) {
    /**
     * http://stackoverflow.com/questions/19907155/
     *   how-to-replace-a-nth-occurrence-in-a-string
     *
     */
    $nth = ( int ) $disabled_index - 1;
    $pattern = 'bb_square__item';
    $found = preg_match_all( '/' . $pattern . '/', $html, $matches, PREG_OFFSET_CAPTURE );
    $html = substr_replace( 
      $html, 
      "$pattern bb_square__item--disabled", 
      $matches[0][$nth][1], 
      strlen( $pattern ) 
    );
  }

  return $html;
}
add_shortcode( 'meet-dtd', 'elit_meet_dtd_shortcode' );

function elit_dropcap_shortcode( $atts = array(), $content = null ) {
  extract(
    shortcode_atts(
      array(
        'color' => 'orange',
      ), $atts
    )
  );

  $content = '<span class="dropcap dropcap--' . $color . '">' . $content . '</span>';

  return $content;
}
add_shortcode( 'dropcap', 'elit_dropcap_shortcode' );

/**
 * TESTING: 
 * Notify Patrick when post status changes
 *
 */
function elit_notify_of_post_status_change($new_status, $old_status, $post) {
  //if ( 'publish' !== $new_status || $new_status === $old_status ||
       //empty($new_status) || empty($old_status) || ($post->post_type !== 'post' &&
       //$post->post_type !== 'page' ) ) {
    //return;
  //}

  if ( 'publish' !== $new_status || empty($new_status) || 
       empty($old_status) || ($post->post_type !== 'post' &&
       $post->post_type !== 'page' ) ) {
      return;
  }

  $modified_author_id = get_post_meta( $post->ID, '_edit_last', true );

  if ( $modified_author_id ) {
    $modified_author_name = get_the_author_meta( 'display_name', $modified_author_id, true );
  }

  $post_title = wp_kses_decode_entities(get_the_title( $post->ID ));
  $post_url = get_permalink( $post->ID );
  $subject = "Status change in '" . $post_title . "'";
  $message  = ( $modified_author_name ? $modified_author_name . ' has updated a post on ' : 'A post has been updated on ');
  $message .= get_bloginfo('name') . "\n\n";
  //$message .= "<a href='" . $post_url. "'>" . $post_title . "</a>\n\n";
  $message .= $post_title . PHP_EOL;
  $message .= $post_url . PHP_EOL . PHP_EOL;
  $message .= "Old status: " . print_r($old_status, true) . PHP_EOL;
  $message .= "New status: " . print_r($new_status, true) . PHP_EOL;

  // send mail
  $headers = 'Content-Type: text/plain' . "\r\n";
  $recipients = array( 'psinco@osteopathic.org', 'bjohnson@osteopathic.org' );
   
  wp_mail( $recipients, $subject, $message, $headers );
}
add_action('transition_post_status', 'elit_notify_of_post_status_change', 10, 3);

/**
 * Whether the current environment is development rather than production.
 */
function elit_is_development_env() {
  return defined( 'DTD_ENV' ) && DTD_ENV === 'development';
}

function elit_add_google_tag_manager_head_code() {
  if ( elit_is_development_env() || is_admin() || is_feed() || is_robots() || 
       is_trackback() ) {
    return;
  }
?>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PJSZNP9');</script>
<!-- End Google Tag Manager -->'

<?php
}
add_action( 'wp_head' , 'elit_add_google_tag_manager_head_code' );

function elit_add_google_tag_manager_page_code() {
  if ( elit_is_development_env() || is_admin() || is_feed() || is_robots() || 
       is_trackback() ) {
    return;
  }
?>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PJSZNP9"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

<?php
}
add_action( 'just_opened_body_tag' , 'elit_add_google_tag_manager_page_code' );

