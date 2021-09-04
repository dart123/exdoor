$(document).ready(function() {

    $('.cat_button').click(function() {
        let title = $(this).data('title');
        window.location.href = '/order.html?btn=' + title;
        //console.log($(this).data('title'));
    });

    // $('.step').click(function(e) {
    //     if ($(this).hasClass('active'))
    //     {
    //         e.preventDefault();
    //         return false;
    //     }
    //
    //     $('.step.active').addClass('filled').css('z-index', 10).removeClass('active');
    //     console.log($(this));
    //     $(this).addClass('active').removeClass('filled').css('z-index', '9');
    // });
});
