<?php $query = get_search_query(); ?>

<form role="search" method="get" class="searchform form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="form-group">
        <label class="sr-only screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
        <input class="form-control default" type="text" value="<?php echo ( empty($query) ) ? '' : $query; ?>" name="s" id="s" />
        <span class="input-group-btn">
            <button class="btn searchGo" type="submit">
                <i class="fa fa-search"></i>
                <i class="fa fa-angle-double-right"></i>
                <span class="sr-only">Search</span>
            </button>
        </span>
    </div>
</form>



