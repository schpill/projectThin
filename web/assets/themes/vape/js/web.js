    $(document).ready(function() {
        $('.openHover').dropdownHover().dropdown();
        $('[rel=tooltip-bottom]').tooltip({
            placement: 'bottom'
        });
        $('[rel=tooltip-top]').tooltip({
            placement: 'top'
        });
        $('[rel=tooltip-left]').tooltip({
            placement: 'left'
        });
        $('[rel=tooltip-right]').tooltip({
            placement: 'right'
        });

        $('.openHover').dropdownHover().dropdown();

        $('.outside_link').each(function(event) {
            event.preventDefault();
            $(this).attr('title', ($(this).attr('title') ? $(this).attr('title') + ' ' : '') + outside);
            $(this).attr('target', '_blank')
        });

        var myNav       = $('#navigation');
        var navPosition = myNav.offset();

        $(window).scroll(function() {
            if($(window).scrollTop() > navPosition.top) {
                myNav.css('position', 'fixed').css('top', 0);
                myNav.css('position', 'fixed').css('z-index', 10);
                $("#scrollToTop").fadeIn('slow');
            } else {
                myNav.css('position', 'static');
                $("#scrollToTop").fadeOut('slow');
            }
        });

        $("#scrollToTop").click(function() {
            $('html, body').animate(
                {scrollTop: 0},
                600
            );
            return false;
        });
    });


    var app = (function () {
        var self = this;
        this._app = {};

        this.show = function (what) {
            if ($(what).is(':visible')) {
                $(what).hide();
            } else {
                $(what).show();
            }
        };

        this.goDiv = function (what) {
            if (!$(what).is(':visible')) {
                $(what).show();
            }
            var myDivTop       = $(what).offset();
            $('html, body').animate(
                {scrollTop: myDivTop.top},
                600
            );
            return false;
        };

        this.showSlide = function (what) {
            if ($(what).is(':visible')) {
                $(what).slideUp();
            } else {
                $(what).slideDown();
            }
        };

        this.showFade = function (what) {
            if ($(what).is(':visible')) {
                $(what).fadeOut();
            } else {
                $(what).fadeIn();
            }
        };

        this.isHovered = function (what) {
            return $(what + ":hover").length > 0;
        };

    });

