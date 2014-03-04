    $(document).ready(function() {
        // alert($('body').width());
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
    });


    var vape = (function () {
        var self = this;
        this._vape = {};
    });

