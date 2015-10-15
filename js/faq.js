(function($) {
          $(document).ready(function() {
               $('.expand_collapse .collapseAll').click(
                    function(event){
                         $('.collapse').collapse('hide');
                         event.preventDefault();
                    });
               $('.expand_collapse .expandAll').click(
                    function(event){
                         $('.collapse').collapse('show');
                         event.preventDefault();
                    });
          });

})(jQuery);
