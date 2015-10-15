<div class="container-fluid">

        <?php $bodyClass = get_layout_class(true); ?>

        <div class="<?php echo $bodyClass; ?> interior-content">

        <div id="right">

            <p class="back-link"><a href="/faqs/">&lsaquo;&nbsp;Back to FAQs</a></p>

            <div class="row">
                <div class="mainContent faq" id="content">
                <!-- WordPress Loop: Only happens if there are posts. -->
                <?php if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : ?>

                        <?php the_post(); ?>

                        <!-- post -->
                        <div id="post-<?php the_ID(); ?>" class="post detail">

                            <h1 class="entry-title"><?php the_field( 'question' ); ?></h1>

                            <?php the_field( 'answer' ); ?>

                        </div><!-- post -->

                    <?php endwhile; ?>
                <?php endif; ?>

                </div><!-- #content -->

                <div id="sidebar"><?php dynamic_sidebar('sidebar-faq'); ?></div>

            </div><!-- .row -->
        </div><!-- #right -->
    </div><!-- .interior-content -->
</div><!-- .container-fluid -->
