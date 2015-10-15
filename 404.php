<?php get_header(); ?>

        <div id="interior">

            <div class="container-fluid">

                <div class="interior-content">

                    <div class="hasNoLeftOrRightCols mainContent">

                        <?php
                            $record_id = get_field('404_not_found', 'option');
                            echo pageTitle($record_id);
                        ?>

                        <div class="entry">
                            <?php
                                getContentByID($record_id);
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>

<?php get_footer(); ?>
