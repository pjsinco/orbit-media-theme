<?php
	if ( !is_active_sidebar( 'sidebar-1' ) ) {
	    //Don't display anything for our 'blank' sidebar. Yes, WordPress makes this function name confusing.
	} else {
		//Proceed as normal
	?>
	    <div id="sidebar">
	    	<?php dynamic_sidebar(); ?>
		</div>
	<?php
	};
?>
