 /**
    *
    *  WP_MobileMenu 1.1 - A jQuery plugin to create mobile navigation menus in WordPress
    *  using the WordPress wp_nav_menu() function and Treeview.
    *
    *  This plugin depends on the following: WordPress (3.5.0) wp_nav_menu(), Treeview
    *
    *  @copyright 2013 Jimmy K.
    *  @version 1.1
    *  @author Jimmy K.
    *  @website http://www.endseven.net/
    *
    */

    ;(function($) {

        $.extend($.fn, {

            $oWrapperElement: null, // The wrapper element around the menu..
            $aSettings: [], // The array of settings..

           /**
            *
            *  Expand or collapse the WP_MobileMenu.
            *  @author Jimmy K.
            *
            */

            toggle: function() {

                if (this.$oWrapperElement.height() > 1) {
                    this.collapse(true);
                } else {
                    this.expand(true);
                }

            },

           /**
            *
            *  Collapse the WP_MobileMenu.
            *  @param $bAnimate Whether or not to animate.
            *  @author Jimmy K.
            *
            */

            collapse: function($bAnimate) {

                if (typeof($bAnimate) === "undefined") {
                    $bAnimate = true; // Set animate to true by default..
                }

                if ($bAnimate) {
                    this.$oWrapperElement.stop().animate({ height: 0 }, 200);
                } else {
                    this.$oWrapperElement.stop().css({ height: 0 });
                }

            },

           /**
            *
            *  Expand the WP_MobileMenu.
            *  @param $bAnimate Whether or not to animate.
            *  @author Jimmy K.
            *
            */

            expand: function($bAnimate) {

                if (typeof($bAnimate) === "undefined") {
                    $bAnimate = true; // Set animate to true by default..
                }

                if ($bAnimate) {

                    this.$oWrapperElement.stop().animate({ height: this.height() }, 200, function()
                    {
                        $(this).css({ height: "auto" }); // Allow future treeview expand/collapse..
                    });

                } else {

                    this.$oWrapperElement.stop().css({ height: "auto" });

                }

            },

           /**
            *
            *  The constructor for this object.
            *  @param $aSettings Some settings to control how this thing works.
            *  @author Jimmy K.
            *
            */

            mobilemenu: function($aSettings) {

                if (typeof($aSettings) !== "undefined") {
                    this.$aSettings = $aSettings; // Store the settings..
                }

                if (typeof($aSettings['wrapper']) !== "undefined") {
                    this.$oWrapperElement = $("#" + $aSettings['wrapper']); // Store the wrapper element..
                }

                if (typeof($aSettings['toggle_button']) !== "undefined") {

                    // Create a reference to the toggle button..
                    var $oToggleButtonRef = this;

                    $("#" + $aSettings['toggle_button']).click(function() {
                        $oToggleButtonRef.toggle();
                    });

                }

                if (typeof($aSettings['close_button']) !== "undefined") {

                    // Create a reference to the close button..
                    var $oCloseButtonRef = this;

                    $("#" + $aSettings['close_button']).click(function() {
                        $oCloseButtonRef.collapse();
                    });

                }

                if ($aSettings['collapsed'] === true) {
                    this.collapse(false); // Collapse the menu without animating..
                }

                if (typeof($aSettings['before']) === "undefined") {
                    $aSettings['before'] = []; // Make sure there's a before array..
                }

                if (typeof($aSettings['after']) === "undefined") {
                    $aSettings['after'] = []; // Make sure there's an after array..
                }

                $("li>a", this.$oElementWrapper).each(function() {

                    // Add the before and after spans..
                    $(this).prepend("<span class='before'></span>").append("<span class='after'></span>");

                });

                $("ul", this.$oElementWrapper).each(function($i) {

                    $("li a", $(this)).each(function() {

                        if ($aSettings['before'][$i]) {
                            $("span.before", $(this)).text($('<div/>').html($aSettings['before'][$i]).text());
                        } else {
                            $("span.before", $(this)).text("");
                        }

                        if ($aSettings['after'][$i]) {
                            $("span.after", $(this)).text($('<div/>').html($aSettings['after'][$i]).text());
                        } else {
                            $("span.after", $(this)).text("");
                        }

                    });

                });

                // Show the menu..
                this.$oWrapperElement.css({ display: "block" });

            }

        });

    })(jQuery);
