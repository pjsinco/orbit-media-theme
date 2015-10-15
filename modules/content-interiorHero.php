<?php if ( has_post_thumbnail( $post->ID ) && 'post' !== $post->post_type ) : ?>

    <div class="outer-row interior-hero">
        <?php the_post_thumbnail( 'full', array('title' => get_the_title( $post ) ) ); ?>
    </div> <!--  .outer-row interior-hero -->

<?php endif; ?>
