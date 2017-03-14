$(document).ready(function () {
    $('.nav-search .search-button').click(function () {
        document.getElementById("navSearch").submit();
    });
    // Nav dropdown
    $('li.dropdown').hover(function () {
        $(this).find('.dropdown-menu').first().show();
    }, function () {
        $(this).find('.dropdown-menu').first().hide();
    });
});
//blink text
(function ($) {
    $.fn.blink = function (options) {
        var defaults = {delay: 500};
        var options = $.extend(defaults, options);
        return $(this).each(function (idx, itm) {
            setInterval(function () {
                if ($(itm).css("visibility") === "visible") {
                    $(itm).css('visibility', 'hidden');
                } else {
                    $(itm).css('visibility', 'visible');
                }
            }, options.delay);
        });
    }
}(jQuery));
$(document).ready(function () {
    $('.blink').blink({delay: 200});
});
