<div id="commentsContainer">
    <?php comments_number( '', '<h6 id="commentsLabel">Comments (1)</h6>', '<h6 id="commentsLabel">Comments (%)</h6>' ); ?></h6>
    <a name="comments"></a>
    <ol class="commentlist">
     <?php if ( $comments ) { ?>

          <!-- THE COMMENTS -->
          <?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>

     <?php } ?>
     </ol>

</div>

<?php comment_form(); ?>

