function calcWidth() {
    /*
    console.log("Pagina cargada productos");
    var item_width = $('#menu li').width();
    var morewidth = $('#menu .more').outerWidth(true);
    console.log("menu li :"+item_width+" y more outerwidth: "+morewidth);

    var item_count = ($("#menu li").length);
    console.log("menu li count :" + item_count);
    */
    var elementSize = $('#menu li').outerWidth(true);

    var morewidth = $('#menu .more').outerWidth(true);

    var navwidth = 0;
    $('#menu > li:not(.more)').each(function () {
        navwidth += $(this).outerWidth(true);
    });
    var availablespace = $('#menu').width() + elementSize - morewidth;
    console.log("navwidth : " + navwidth + " Available space " + availablespace);
    console.log("Llamado a calcwidth..");

    if (navwidth > availablespace) {
        console.log("Se AGREGA EL MORE");
        var lastItem = $('#menu > li:not(.more)').last();
        //lastItem.removeClass("imgContainer");
        lastItem.prependTo($('#menu .more ul'));
        calcWidth();
    } else {
        var firstMoreElement = $('#menu li.more li').first();
        if (navwidth + elementSize < availablespace) {
            //firstMoreElement.addClass("imgContainer");
            firstMoreElement.insertBefore($('#menu .more'));
        }
    }

    if ($('.more li').length > 0) {
        $('.more').css('display', 'flex');
    } else {
        $('.more').css('display', 'none');
    }
}

$(window).on('resize load', function () {

    calcWidth();
});
