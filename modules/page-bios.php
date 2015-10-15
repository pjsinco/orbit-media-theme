
<?php the_content(); ?>

<?php

//Get the relationship
$posts = get_field('bios');

if( $posts ): ?>
    <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
        <?php setup_postdata($post); ?>
        <?php
            echo '<div class="bio">';
                echo '<a href="'.get_permalink().'"><img src="'.get_field('bio_image').'" class="glyph" /></a>';
                echo '<div class="desc">';
                    echo '<div class="name"><a href="'.get_permalink().'">'.get_the_title().'&nbsp;›</a></div>';
                    echo '<div class="title">'.get_field('position').'</div>';
                echo '</div>';
            echo '</div>';
        ?>
    <?php endforeach; ?>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>
