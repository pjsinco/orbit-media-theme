<?php
class Search {

    public function __construct() {
        //add your actions to the constructor!
        add_filter('pre_get_posts', array( $this, 'fix_empty_search'));
        add_filter('relevanssi_pre_excerpt_content', array( $this, 'excerpt_function'));
        add_filter('relevanssi_content_to_index', array( $this, 'getPageBlockContent'));
    }

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

}


