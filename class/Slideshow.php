<?php
class Slideshow {

    /**
     * Outputs a Bootstrapped Carousel using Advanced Custom Fields
     * @author Andi Ruggles <andi@orbitmedia.com>
     * @return string
     */
    public function slideshow()
    {

        $record_id = get_queried_object_id();

        if(get_field('slideshow', $record_id)) {

            //Get all Slideshow repeater fields
            $rows = get_field('slideshow', $record_id);


            if($rows) {

                $i = 0;
                $slides = '';
                $indicators = '';

                foreach($rows as $row) {

                    //Add the 'active' class to the first element
                    if($i == 0) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }

                    //Slides
                    $slides .= $this->formatSingleSlide($row, $active);

                    //Indicators
                    $indicators .= '<li data-target="#slideshow" class="'.$active.'" data-slide-to="'.$i.'"></li>';

                    $i++;
                }

                $controls = $this->outputSlideControls();

                //Carousel Wrapper
                $carousel = '
                <div id="slideshow" class="slide" data-ride="carousel">
                    <div class="carousel-inner">
                        '.$slides.'
                    </div>
                    '.$controls.'
                    <ol class="carousel-indicators">
                        '.$indicators.'
                    </ol>
                </div>
                ';

              return $carousel;

            }
        }
    }

    /**
     * Formats the Individual Slides in a Slideshow/Carousel
     * @author Andi Ruggles <andi@orbitmedia.com>
     * @param  arr $row    All slide data
     * @param  string $active Adds the 'active' class if it's the first slide
     * @return string  Slideshow slides
     */
    public function formatSingleSlide($row, $active = '')
    {

        //Gets the current page/post ID outside the loop.
        $record_id = get_queried_object_id();

        $slide = '
          <div class="item '.$active.'">
            <img src="'.$row['slideshow_image'].'" />
              <div class="carousel-caption text-left">
                <span><span>'.$row['slideshow_text'].'</span></span><br />
                <a href="'.$row['slideshow_url'].'" class="button">'.$row['button_text'].'</a>
              </div>
          </div>';

        return $slide;
    }

    /**
     * Outputs the < and > icons
     * @author Andi Ruggles <andi@orbitmedia.com>
     */
    public function outputSlideControls()
    {
        $controls = '
            <a class="left carousel-control" href="#slideshow" data-slide="prev"><span class="fa fa-angle-left"></span></a>
            <a class="right carousel-control" href="#slideshow" data-slide="next"><span class="fa fa-angle-right"></span></a>
        ';

        return $controls;
    }

/* END CLASS */
}
