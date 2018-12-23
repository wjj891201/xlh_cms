$(function () {
    $('.accordion').accordion({
        event: 'click',
        showfirst: false
    });
    $('.accordion >dd>a').click(function () {
        $(".accordion >dd>a").each(function () {
            $(this).removeClass("choose");
        });

        $(this).addClass("choose");
    });
    $('.search input[type=text]').focus(function () {
        if (this.value == this.defaultValue) {
            this.value = "";
        }
    }).blur(function () {
        if (this.value == "") {
            this.value = this.defaultValue;
        }
    });
//    var h = $(this).height();
//    var H = $('.head-bar').height() + $('.main-bar').height();
//    if (h < H) {
//        $('.left-nav').height(H);
//    } else {
//        $('.left-nav').height(h);
//    }
});