<?php
class Menus {

    public function __construct() {
        //add your actions to the constructor!
        add_filter('wp_nav_menu', array( $this, 'add_first_and_last'));
        add_filter('wp_nav_menu_objects', array( $this, 'oms_wp_nav_menu_objects_sub_menu'));
    }

/**
     * Adds 'first-menu-item' and 'last-menu-item' classes to the menu LI elements.
     *
     * @author Andi Ruggles <andi@orbitmedia.com>
     * @author Jimmy K. <jimmy@orbitmedia.com>
     */

    function add_first_and_last($output) {

        // Add the "first-menu-item" class to the first item.
        $output = preg_replace('/class="menu-item/', 'class="first-menu-item menu-item', $output, 1);

        // Get the # of items that have the "menu-item" class.
        $count = substr_count($output, 'class="menu-item');

        if ($count >= 2) {
            // If we have two or more menu items, add the "last-menu-item" class to the last item.
            $output = substr_replace($output, 'class="last-menu-item menu-item', strripos($output, 'class="menu-item'), strlen('class="menu-item'));
        }

        return $output;

    }

    /**
     * Get the top ancestor of a page.
     *
     * @return int
     * @author Jimmy K. <jimmy@orbitmedia.com>
     */

    function get_top_level_page_id($iPostID)
    {

        // Get the post.
        $oPost = get_post($iPostID);

        if (!$oPost->post_parent) {
            // Post doesn't have a parent.
            return $oPost->ID;
        }

        // Post has a parent.
        return $this->get_top_level_page_id($oPost->post_parent);

    }

    function getCustomPostTypeParent($joinTable, $relationshipName)
    {

        $query = get_posts(array(
            'post_type' => $joinTable,
            'meta_query' => array(
                array(
                    'key' => $relationshipName, // name of the ACF relationship custom field (not the CPT name)
                    'value' => '"' . get_the_ID() . '"',
                    'compare' => 'LIKE'
                )
            )
        ));

        return $query[0]->ID;
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
    function oms_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args = array() ) {

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

}


