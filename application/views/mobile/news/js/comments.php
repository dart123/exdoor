<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.07.17
 * Time: 0:21
 */
?>
<script>


    $('body').on('click', '.js-show-all-comments', function (event) {

        var news_id     = $(this).attr('data-news-id'),
            this_obj    = $(this);

        $.post('/ajax/load_all_comments',
            { 'news_id': news_id },
            function(result) {
                var data = $.parseJSON(result);
                if (data) {
                    var template = $('#mustache__news_comments').html(),
                        output = Mustache.render(template, data);
                    $('.news_'+news_id+'_replys').prepend(output);
                    this_obj.hide();
                }
            }
        );
        return false;
    });




    ajax_send_news_comment = function( comment, news_id, user_id ) {

        $('.preloader').fadeIn();
        $('.preloader__img').fadeIn();
        $('body').delay(350).css({'overflow':'hidden'});

        $(this).closest('.reply__form-box').children('textarea').val('');

        if( comment == '' ) {
            $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка")
                .attr('data-notifyText',  'Вы не можете оставлять пустые комментарии')
                .click();
        } else if( !news_id || !user_id ) {
            $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка")
                .attr('data-notifyText',  'Позникла неизвестная ошибка, обратитесь к администратору')
                .click();
        } else {
            $.post('/ajax/news_add_comment',
                { 'comment': comment, 'news_id': news_id, 'user_id': user_id },
                function(result) {
                    var data = JSON.parse( result );

                    if (data == 'true') {

                    } else {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка")
                            .attr('data-notifyText',  'Позникла неизвестная ошибка, обратитесь к администратору')
                            .click();
                    }
                });
        }

        $('.preloader__img').fadeOut();
        $('.preloader').delay(350).fadeOut('slow');
        $('body').delay(350).css({'overflow':'visible'});

    };

    $('body').on( 'click', '.ajax-news-leave-comment', function () {

        var comment     = $(this).closest('.news-advpost__form').find('textarea').val(),
            news_id     = $(this).attr('data-news-id'),
            user_id     = $(this).attr('data-author-id');

        ajax_send_news_comment( comment, news_id, user_id );
        $('textarea.js__news__add_comment').val('');
    });


    $('.js__news__add_comment').keypress(function(event) {

        var comment     = $(this).val(),
            news_id     = $(this).attr('data-news-id'),
            user_id     = $(this).attr('data-author-id');

        if ( !event.ctrlKey && !event.altKey && !event.shiftKey && event.which == 13 ) {

            event.preventDefault();
            if( comment ) {
                ajax_send_news_comment( comment, news_id, user_id );
                $(this).val('');
            }
            else {
                $('.notify-trigger--alert').attr('data-notifyTitle', 'Сообщение не отправлено')
                    .attr('data-notifyText',  'Вы не можете отправлять пустые сообщения!')
                    .click();
            }
        } else if ( ( event.ctrlKey || event.altKey || event.shiftKey ) && event.which == 13 ) {
            event.preventDefault();
            insertTextAtCursor ( this, '\n' );
        }
    });







    $('body').on('click', '.ajax-edit-message', function (event) {

        $.fancybox.close();

        var comment_id = $(this).attr( 'data-message-id' );

        $.ajax({
            url:   '/ajax/get_comment',
            data: {
                comment_id: comment_id
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function(xhr){
                /*
                 $('.preloader').fadeIn();
                 $('.preloader__img').fadeIn();
                 $('body').delay(350).css({'overflow':'hidden'});
                 */
            },
            success: function(result){
                if (result) {
                    $('#ajax__input__news_comment_id').val( result.id );
                    $('#ajax__input_edit_news_comment_content').val( result.comment );
                    $.fancybox.open({
                        href        : '#edit-news-comment',
                        closeBtn    :  false,

                    });
                }
            },
            complete: function( result ){
                $('.preloader__img').fadeOut();
                $('.preloader').delay(350).fadeOut('slow');
                $('body').delay(350).css({'overflow':'visible'});

                $( "#filelist_news" ).html('');
                $('#ajax__input__news_content').val('');
            }
        });
    });

    $('body').on('click', '#ajax__submit__edit_news_comment', function (event) {

        var id      = $('#ajax__input__news_comment_id').val(),
            comment = $('#ajax__input_edit_news_comment_content').val();

        $.ajax({
            url:   '/ajax/edit_comment',
            data: {
                id          : id,
                comment     : comment,
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function(xhr){
                $('.preloader').fadeIn();
                $('.preloader__img').fadeIn();
                $('body').delay(350).css({'overflow':'hidden'});
            },
            success: function(result){
                if ( result == true ) {

                    $.fancybox.close();
                    $('.news__comment-'+id+' > .reply__content > .reply__text').text( comment );

                } else if ( result == 'no_permissions') {
                    $.fancybox.close();
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'У Вас нет прав на изменение этого комментария!')
                        .click();
                }
            },
            complete: function( result ){
                $('.preloader__img').fadeOut();
                $('.preloader').delay(350).fadeOut('slow');
                $('body').delay(350).css({'overflow':'visible'});

                $( "#filelist_news" ).html('');
                $('#ajax__input__news_content').val('');
            }
        });

    });







    $('body').on('click', '.ajax-remove-message', function (event) {
        var id = $(this).attr('data-message-id');

        $('.news__comment-'+id+ '> .after_removing_background').show();

        $.post('/ajax/remove_news_comment',
            { 'id': id },
            function(result) {
                data    = $.parseJSON(result);
                if ( data == "true" ) {

                    //

                } else if ( data == 'no_permissions') {
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'У Вас нет прав на удаление этого комментария!')
                        .click();
                    $('.news__comment-'+id+ '> .after_removing_background').hide();
                }

            }
        );
    });

    $('body').on( 'click' , '.ajax__undo_remove_news_comment', function() {
        var id = $(this).attr('data-comment-id');
        $('.news__comment-'+id+ '> .after_removing_background').hide();

        $.post('/ajax/undo_remove_news_comment',
            {
                'action'    : 'undo_remove_comment',
                'id'        : id,
            },
            function(result) {
                if (!result) {
                    $('.news__comment-'+id+ '> .after_removing_background').show();
                }
            }
        );
    });
</script>
