/* Returns 'x/y' coordinates for window size
 *
 * @return {string} JSON string including 'x/y' coordinates
 * @author Mark Furrow <mark@orbitmedia.com>
 */
function windowSize()
{
    var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName('body')[0],
        x = w.innerWidth || e.clientWidth || g.clientWidth,
        y = w.innerHeight|| e.clientHeight|| g.clientHeight;

    return {'x':x,'y':y};
}

function currentBreakpoint()
{
    var sm_screen = 480,
        md_screen = 768,
        lg_screen = 992;

    var window_size = windowSize().x;

    if ( window_size <= sm_screen ) {
        return 'xs';
    }

    if ( window_size > sm_screen && window_size <= md_screen ) {
        return 'sm';
    }

    if ( window_size > md_screen && window_size <= lg_screen ) {
        return 'md';
    }

    if ( window_size > lg_screen ) {
        return 'lg';
    }
}


var waitForFinalEvent = (function () {

    var timers = {};

    return function (callback, ms, uniqueId) {
        if (!uniqueId) {
            uniqueId = "Don't call this twice without a uniqueId";
        }
        if (timers[uniqueId]) {
            clearTimeout (timers[uniqueId]);
        }
        timers[uniqueId] = setTimeout(callback, ms);
    };

})();

window.addEventListener( 'deviceorientation', handleOrientation, true);

function handleOrientation(e) {
    console.log(e);
}

(function($) {

    // INITIALIZE SOLAR BOX ON PAGE LOAD HERE
    $(document).ready(function(){
        $("a[data-solarbox]").solarBox({
             countSeparator:"/", //SEPARATOR BETWEEN CURRENT NUMBER AND COUNT (DEFAULT: "/")
             mobileBreak:768, //SCREEN WIDTH WHEN IT BEHAVES LIKE MOBILE DEVICE (DEFAULT: 768)
             fullscreen:false, //OPEN FULLSCREEN FOR LARGE SCREENS BY DEFAULT (DEFAULT: false)
             closeInBottom:false, //PLACE CLOSE BUTTON IN BOTTOM (DEFAULT: false)
             addThis:false, //USE ADDTHIS SHARING (DEFAULT: false)
             //addThisHtml:"", //CUSTOM HTML FOR SHARETHIS ICONS
             changeHash:false, //ALLOW HASH TO BE UPDATED FOR AUTO-OPENING AND SOCIAL TOOLS (DEFAULT: false)
             fullScreenPadding:42, //SETS LIMIT ON SIZE OF BOX WITH PADDING AROUND THE SCREEN (DEFAULT: 42)
             videoDefaultWidth:560, //DEFAULT WIDTH FOR VIDEOS IF NONE SUPPLIED (DEFAULT: 560)
             videoDefaultHeight:314, //DEFAULT HEIGHT FOR VIDEOS IF NONE SUPPLIED (DEFAULT: 314)
             swipeThreshold:200, //SWIPE DETECTION PIXEL WIDTH (DEFAULT: 200)
             onSolarOpen:false, //CALLBACK FUNCTION TO BE CALLED WHEN OPENED
             onSolarClose:false, //CALLBACK TO BE CALLED WHEN CLOSED
             onSolarChange:false //CALLBACK TO BE CALLED WHEN OPENED
        });
    });

    if ( $('body').hasClass('home') ) {
        // init_hero();
    }

    init_searchform( '#searchform-desktop .searchform','Enter Keywords...' );
    init_searchform( '#searchform-mobile .searchform', 'Enter Keywords...' );
    init_searchform( '#sidebar .searchform', 'Enter Keywords...' );

    /**
     * Manage Hero Image Heights Dynamically
     *
     * @author Mark Furrow <mark@orbitmedia.com>
     */
    function init_hero() {

        var $hero = $('.hero--image');
        var header_offset = $('header.outer-row').height();

        // var footer_offset = $('.hero--band').height();


        var max_height = {
            xs : 170,
            sm : 170,
            md : 420,
            lg : 760
        }

        var breakpoint = currentBreakpoint();
        var adjusted_height = max_height[breakpoint] + header_offset;

        $hero.height( 'auto' );

        if ( adjusted_height > windowSize().y ) {
            $hero.height( windowSize().y - header_offset );
        } else {
            $hero.height( max_height[breakpoint] );
        }

        // console.log( breakpoint );

        // if ( breakpoint == 'md' ) {
        //     $hero.height( windowSize().y - footer_offset );
        // }

        $(window).resize(function () {
            waitForFinalEvent(function(){
                init_hero();
            }, 500, "oms_hero");
        });

    }

    /**
     * Manage Input Placeholder Text
     *
     * @param  {string} default_text Default text
     * @author Mark Furrow <mark@orbitmedia.com>
     */
    function init_searchform( selector, default_text ) {

        var default_text = default_text || 'Search';

        if ( $( selector ).length >= 1 ) {

            var $input = $( selector ).find('.form-control');

            $input.val( default_text );

            $input.focus(function() {

                if ( $(this).val() == default_text ) {
                    $(this).val( '' );
                    $(this).removeClass( 'default' );
                }

            }).blur(function() {

                if ( $(this).val() == '' ) {
                    $(this).val( default_text );
                    $(this).addClass( 'default' );
                }

            });

            // Prevent submit if default value
            $( selector ).submit(function(e) {

                if ( $(this).find('.form-control').val() == default_text ) {
                    e.preventDefault();
                }

            });

        }
    }

})( jQuery );
