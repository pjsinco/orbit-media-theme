<?php
class FAQs {

    /**
     * Outputs the entire chunk of FAQs
     * @author Mike Biel <mike@orbitmedia.com>
     */
    function outputFaqs()
    {
        //Gets the current page id
        $post_id = get_queried_object_id();

        $return = '';
        $faqHTML = '';

        $faqs = get_field('related_faqs', $post_id);
        $show_adv_options = get_field('show_adv_options', $post_id);

        if( $faqs ):
            foreach( $faqs as $k => $f): // variable must be called $post (IMPORTANT)
                // Question
                $question = $this->faqQuestion(get_field('question', $f->ID), $f->ID, (0 == $k) );
                // Answer
                $answer = $this->faqAnswer(get_field('answer', $f->ID), $f->ID,
                (0 == $k) );
                // Output Formatting
                $faqHTML .= $this->formatFAQ($question, $answer);

            endforeach;

            $advOptions = ( $show_adv_options )?
                 $this->outPutAdvancedExpHTML():
                 '';

            $return = '
                <!-- START THE FAQS!!1!1!111 -->
                <div class="container-fluid">
                    <div class="row">
                        <div id="faqBlock" class="block">
                                ' . $advOptions . '
                            <div class="group-holder">
                                ' . $faqHTML  . '
                            </div>
                                ' . $advOptions . '
                        </div>
                    </div>
                </div>';

        endif;

        return $return;
    }

    /**
     * Outputs Advanced Expansion/Collapse control HTML
     * @author Mike Biel <mike@orbitmedia.com>
     * @return string HTML of the control
     */

    function outPutAdvancedExpHTML(){

        $return = "<!-- Advanced Expand Collapse Controls -->
            <div class='expand_collapse'>
                <a href='#' class='expandAll'>Expand All</a>
                <a href='#' class='collapseAll'>Collapse All</a>
            </div>
        ";

        return $return;
    }

    /**
     * Outputs a single FAQ row
     * @author Mike Biel <mike@orbitmedia.com>
     * @param  string $question HTML of FAQ Question
     * @param  string $answer HTML of FAQ Answer
     * @return string Formatted HTML of single FAQ
     */
    function formatFAQ($questionHTML, $answerHTML) {

        $faqHTML = '
            <div class="faqItem">
                ' . $questionHTML . '
                ' . $answerHTML . '
            </div>
            ';

        return $faqHTML;
    }

    /**
     * Formats the Question Element for an FAQ
     * @author Mike Biel <mike@orbitmedia.com>
     * @param  string $questionText Question text
     * @param  string $faqID FAQ ID
     * @return string Formatted Question HTML
     */
    function faqQuestion($questionText, $faqID, $open = false )
    {
        if(!empty($questionText)) {
            $openClass = ( !$open )?'collapsed':'';
            $expanded = ( $open )?"true":"false";
            $questionHTML = '<!-- FAQ Header -->
                <div class="collapse-heading">
                      <h4><a class="collapse-toggle ' . $openClass . '" data-toggle="collapse" aria-expanded="' . $expanded . '" href="#faqAnswer-' . $faqID . '">
                        ' . $questionText . '
                      </a></h4>
                </div>
            ';
        }

        return $questionHTML;
    }

    /**
     * Formats the Answer Element for an FAQ
     * @author Mike Biel <mike@orbitmedia.com>
     * @param  string $answerText Answer text
     * @param  string $faqID FAQ ID
     * @return string Formatted Anwer HTML
     */
    function faqAnswer($answerText, $faqID, $open = false)
    {
        if(!empty($answerText)) {
            $openClass = ($open)?'in':'';
            $answerHTML = ' <!-- FAQ ANSWER -->
             <div id="faqAnswer-' . $faqID . '" class="collapse-body collapse '.
             $openClass . '">
                <div class="collapse-inner">
                    ' . $answerText . '
                </div>
            </div>
            ';
        }

        return $answerHTML;
    }



}
