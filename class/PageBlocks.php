<?php

class PageBlocks {

    // General Pageblock Properties
    protected static $ID;
    protected static $layout;
    protected static $has_flag;
    protected static $reverse;

    protected static $row_classes = array();
    protected static $combo_class = '';

    // Pageblock Content
    protected static $header = '';
    protected static $left;
    protected static $middle;
    protected static $right;

    public static $column_definitions = array( 'left', 'middle', 'right' );

    /**
     * Outputs the entire chunk of Page Blocks
     * @author Andi Ruggles <andi@orbitmedia.com>
     * @author Mark Furrow
     */
    public static function output()
    {
        $page_block_rows = '';
        // Gets the current page id
        $page_id = get_queried_object_id();

        $posts = get_field('page_blocks_join', $page_id);

        if ( $posts ) :
            foreach ( $posts as $p ): // variable must be called $post (IMPORTANT)

                $columns = '';

                self::$ID       = $p->ID;
                self::$layout   = get_field( 'layout', self::$ID );
                self::$has_flag = get_field( 'add_flag', self::$ID );

                // Hidden?
                if ( get_field( 'hidden', self::$ID ) != 'yes' ) {

                    // Set Header Data
                    self::setHeader();

                    // Set Column Data
                    self::setColumnsData();

                    // Display For: One, Two, or Three Cols
                    $columns = self::formatColumns();

                    // Build collection of Rows
                    $page_block_rows .= self::formatRow( $columns );

                }

                $return = '
                    <div id="pageBlocks">
                        '. $page_block_rows .'
                    </div>
                ';

            endforeach;
        endif;

        echo $return;

    }

    protected static function formatColumns()
    {

        // Reset Reverse Flag For Each Row
        self::$reverse = '';

        // Display For: Three Cols
        if ( self::$layout == 'three_column_block' ) {

            return self::$left . self::$middle . self::$right;

        }

        // Display For: Two Cols
        if ( self::$layout == 'two_column_block' ) {

            $right_content_type = get_field( 'right_content_type', self::$ID );

            if ( self::$layout == 'two_column_block' && $right_content_type != 'text' ) {

                self::$reverse = 'reverse';
                return self::$right . self::$left;

            } else {

                return self::$left . self::$right;

            }
        }

        // Display For: 1 Col
        return self::$left;

    }

    /**
     * Outputs a single page block row
     * @author Andi Ruggles <andi@orbitmedia.com>
     * @param  string $header    Header above a row of page blocks
     * @param  string $pageBlock All single page blocks in the row
     * @param  string $layout    Layout of this row of page blocks
     */
    protected static function formatRow( $pageBlock )
    {

        $class = array(
            self::$layout,
            self::$reverse,
            self::$combo_class,
        );

        $background_image = '';
        if ( get_field( 'apply_background_image', self::$ID ) && get_field( 'background_image', self::$ID ) ) {
            $background_image = 'style="background-image: url('. esc_html( get_field( 'background_image', self::$ID ) ) .')"';
            array_push( $class, 'image' );
        }

        $row = '
            <div class="page-block '. implode(' ', $class) .'"'. $background_image .'>
                <div class="container-fluid">
                    <div class="row">
                        <div class="inner"></div>
                        '. self::$header .'
                        '. $pageBlock .'
                    </div>
                </div>
            </div>';

        return $row;
    }

    /**
     * Formats the Header for the entire row of blocks
     *
     * @author Andi Ruggles <andi@orbitmedia.com>
     * @author Mark Furrow <mark@orbitmedia.com>
     */
    protected static function setHeader()
    {
        if ( get_field( 'header', self::$ID ) ) {
            self::$header = '
                <div class="sectionHeader">
                    <div class="header">'. get_field( 'header', self::$ID ) .'</div>
                </div>
            ';
        }
    }

    /**
     * Formats an individual block in a row
     *
     * @author Andi Ruggles <andi@orbitmedia.com>
     * @author Mark Furrow <mark@orbitmedia.com>
     */
    protected static function setColumnsData()
    {

        $combo_classes = array('combo');

        foreach ( self::$column_definitions as $placement ) {

            $content = '';
            $content_type = get_field( $placement.'_content_type', self::$ID );

            if ( ! empty($content_type)) {
                array_push( $combo_classes, $content_type );
            }

            if ( $content_type == 'text') {

                $content .= self::textBlock(get_field('text_'.$placement, self::$ID));

            } elseif ( $content_type == 'image' ) {

                $content .= self::imageTag(get_field('image_'.$placement, self::$ID));
                $content .= self::mediaCaption(get_field('caption_'.$placement, self::$ID));

            } elseif ( $content_type == 'testimonial' ) {

                $content .= self::fullTestimonial(get_field('testimonial_'.$placement, self::$ID));

            } else {

                // $content .= self::responsiveVideo(get_field('video_'.$placement, self::$ID));
                // $content .= self::mediaCaption(get_field('caption_'.$placement, self::$ID));

                $content .= self::solarBoxVideo( $placement );

            }

            switch ( $placement ) {
                case 'left':
                    self::$left = self::columnWrapper( $content_type, $content );
                    break;
                case 'middle':
                    self::$middle = self::columnWrapper( $content_type, $content );
                    break;
                case 'right':
                    self::$right = self::columnWrapper( $content_type, $content );
                    break;
            }
        }

        self::$combo_class = implode('_', $combo_classes );

    }


    protected static function columnWrapper( $content_type, $content )
    {
        return '
            <div class="block '. $content_type .'">
                <div class="wrapper table">
                    <div class="cell">
                        '. $content .'
                    </div>
                </div>
            </div>
        ';
    }

    /**
     * Formats the page block chunks of text. Assumes there will always be an icon.
     * @author Andi Ruggles <andi@orbitmedia.com>
     * @param  string $text page block text
     * @param  string $icon icon class (from Font Awesome)
     * @param  string $link url to link the entire block to
     */
    protected static function textBlock( $text )
    {
        return ( (self::$has_flag) ? '<span class="stars"></span>' : '') . $text;
    }

    /**
     * Formats page block images
     * @author Andi Ruggles <andi@orbitmedia.com>
     * @param  string $imagePath path to the image
     * @param  string $alt       alt tag
     * @param  string $url       url to link the image to
     */
    protected static function imageTag($imagePath = '', $alt = '', $url = '')
    {
        if($imagePath != '') {
            return '<div class="img-wrapper circle"><img src="'.$imagePath.'" alt="'.$alt.'"></div>';
        }
    }

    /**
     * Wraps the Embed code in the necessary wrapper.
     * @author Andi Ruggles <andi@orbitmedia.com>
     * @param  string $embed [description]
     */
    protected static function responsiveVideo($embed = '')
    {
        if($embed != '') {
            return '<div class="embed-responsive embed-responsive-16by9">'.$embed.'</div>';
        }
    }

    protected static function solarBoxVideo( $placement )
    {

        $thumbnail_src = get_field( 'image_'.$placement, self::$ID );
        $video_link = get_field( 'video_'.$placement, self::$ID );
        $video_caption = get_field( 'caption_'.$placement, self::$ID );

        if ( $thumbnail_src ) {

            $thumbnail_image = '
                <div class="img-wrapper">
                    <img src="' . esc_html( $thumbnail_src ) . '" alt="'. esc_html( $video_caption ) .'">
                </div> <!-- .img-wrapper -->
            ';
        }

        $return = '
            <div class="sideBar_VideoInner">
                <a href="'. $video_link .'" title="'. esc_html( $video_caption ) .'" data-solarbox="pageblock" data-solartitle="'. esc_html( $video_caption ) .'" data-solarheight="400" data-solarwidth="600">
                    ' . $thumbnail_image . '
                    <div class="button">
                        <i class="fa fa-play"></i><span>PLAY VIDEO</span>
                    </div>
                </a>
            </div><!-- sideBar_VideoInner -->
        ';


        if ( $thumbnail_src && $video_link ) {
            return $return;
        }
    }

    /**
     * Full size page block testimonial
     * @author Joe Hanson <joe@orbitmedia.com>
     * @param  string $embed [description]
     */
    protected static function fullTestimonial( $data )
    {
        $byline = '';
        if ( get_post_meta($data->ID)['_byline'][0] ) {
            $byline = '
                <span class="byline">, '. esc_html( get_post_meta($data->ID)['_byline'][0] ) .'</span>
            ';
        }
        $return = '
            <span class="quote"><img src="'. get_stylesheet_directory_uri() .'/images/quote.png" alt="opening quote"></span>
            <blockquote>'. esc_html( $data->post_content ) .'</blockquote>
            <span class="name">--'. esc_html( $data->post_title ) .'</span>
            '. $byline .'
        ';
        return $return;
    }

    protected static function mediaCaption($data)
    {
        $return = '
            <div class="media-caption">
                '. $data .'
            </div>
        ';
        return $return;
    }

}
