<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 19.01.17
 * Time: 19:22
 */
?>

<script>



    $(document).ready(function () {



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
                success: function(result){
                    if (result) {
                        $('#ajax__input__news_comment_id').val( result.id );
                        $('#ajax__input_edit_news_comment_content').val( result.comment );
                        $.fancybox.open({
                            src : '#edit-news-comment'
                        });
                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');

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
                },
                success: function(result){
                    if (result) {

                        $.fancybox.close();

                        $('.notify-trigger--success').attr('data-notifyTitle', "Успешно")
                            .attr('data-notifyText',  'Комментарий отреадиктирован')
                            .click();

                        $('.news__comment-'+id+' > .reply__content > .reply__text').text( comment );

                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');

                    $( "#filelist_news" ).html('');
                    $('#ajax__input__news_content').val('');
                }
            });

        });

        $('body').on('click', '.ajax-remove-message', function (event) {
            var id = $(this).attr('data-message-id');
            $.post('/ajax/remove_news_comment',
                { 'id': id },
                function(result) {
                    $('.news__comment-'+id+ '> .after_removing_background').show();

                    $('.notify-trigger--success').attr('data-notifyTitle', 'Успешно')
                        .attr('data-notifyText',  'Ваш комментарий успешно удален!')
                        .click();
                }
            );
        });

        $('body').on( 'click' , '.ajax__undo_remove_news', function() {
            var id = $(this).attr('data-comment-id');
            $.post('/ajax/undo_remove_news_comment',
                {
                    'action'    : 'undo_remove_comment',
                    'id'        : id,
                },
                function(result) {
                    if (result) {
                        $('.news__comment-'+id+ '> .after_removing_background').hide();
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Действие отменено')
                            .attr('data-notifyText',  'Ваш комментарий успешно восстановлен!')
                            .click();
                    }
                }
            );
        });

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
        });

        $('.fancybox__add_news').click( function() {

            $('#filelist_news').html('');
            $('#ajax__input__news_content').val('');

            $('#add-news').find('.modal__title').text('Добавить новость');
            $('#ajax__input__news_id').val( '' );
            $("#ajax__input__action").val( 'add_news' );
            $('#add-news').find(".add-news__submit").val("Опубликовать");

            $.fancybox.open({
                helpers     : {
                    overlay : {
                        locked: true
                    }
                },
                closeBtn    : false,
                src        : '#add-news'
            });
        });

        $('body').on( 'click', '#ajax__submit__add_edit_news',  function ( event ) {
            event.preventDefault();
            var action      = $("#ajax__input__action").val(),
                author_id   = $("#ajax__input__author_id").val(),
                content     = $("#ajax__input__news_content").val(),
                images      = [];

            $( "#filelist_news > li" ).each(function( index ) {
                if ( !$(this).hasClass('js__existing_image') )
                    images.push( $(this).find('img').attr('src') );
            });

            if( action == "add_news" )
            {
                $.ajax({
                    url:   '/ajax/add_news',
                    data: {
                        author_id           : author_id,
                        content             : content,
                        images              : images
                    },
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function(xhr){
                        $('.preloader').fadeIn();
                        $('.preloader__img').fadeIn();
                    },
                    success: function(result){
                        if (result) {
                            $.fancybox.close();

                            if( !result.is_first_news )
                                $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                    .attr('data-notifyText',  'Ваша новость успешно добавлена!')
                                    .click();
                        }
                    },
                    complete: function( result ){
                        $('.preloader__img').fadeOut();
                        $('.preloader').delay(350).fadeOut('slow');
                    }
                });
            }
            else if( action == "edit_news")
            {
                var existing_images = [],
                    news_id         = $("#ajax__input__news_id").val();

                $( "#filelist_news > li" ).each(function( index ) {
                    if ( $(this).hasClass('js__existing_image') )
                        existing_images.push( $(this).find('img').attr('data-original-src') );
                });
                $.ajax({
                    url:   '/ajax/edit_news',
                    data: {
                        news_id             : news_id,
                        content             : content,
                        post_images         : images,
                        existing_images     : existing_images
                    },
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function(xhr){
                        $('.preloader').fadeIn();
                        $('.preloader__img').fadeIn();
                    },
                    success: function(result){
                        if (result) {
                            $.fancybox.close();
                            var data            = result,
                                template        = $('#mustache__news_loop').html(),
                                template_modal  = $('#mustache__news_loop_modal').html(),
                                output          = Mustache.render(template, data),
                                output_modal    = Mustache.render(template_modal, data);

                            $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                .attr('data-notifyText',  'Ваша новость успешно изменена!')
                                .click();

                            $("#js__news_list__news_"+news_id).replaceWith( output );
                            $("#news-post"+news_id).replaceWith( output_modal );

                            reinitializeMasonry();
                        } else {
                            alert('error');
                        }
                    },
                    complete: function( result ){
                        $('.preloader__img').fadeOut();
                        $('.preloader').delay(350).fadeOut('slow');

                        $( "#filelist_news" ).html('');
                        $('#ajax__input__news_content').val('');
                    }
                });

            }


        });

        $("body").on("click", '.ajax__news_edit', function () {
            var news_id  = $(this).attr('data-id');
            $.fancybox.close();

            $( "#filelist_news" ).html('');

            $.post('/ajax/get_news_item',
                { 'news_id':news_id },
                function(result) {
                    if (result) {
                        $.fancybox.close();
                        var data  = $.parseJSON(result);

                        $('#add-news').find('.modal__title').text('Изменить новость');
                        $('#ajax__input__news_id').val( news_id );
                        $("#ajax__input__action").val( 'edit_news' );
                        $('#add-news').find(".add-news__submit").val("Изменить");

                        $('#ajax__input__news_content').val( data.content ).change();

                        $.each( data.images, function( key, value ) {
                            $('#filelist_news').append('<li class="js__existing_image"><img src="/uploads/news/'+news_id+'/small_'+value+'" data-original-src="'+value+'"><a href="#" class="remove js-remove_existing_image" data-image-original-name="images.jpeg"></a></li>');
                        });
                        $.fancybox.open({
                            src : '#add-news'
                        });
                    }
                }
            );

            $("#ajax__input__news_content").val(
                $("#js__news_list__news_" + news_id ).find(".news-advpost__text > p").text()
            );

        });

        $("body").on("click", '.ajax__news_remove', function () {
            var id  = $(this).attr('data-id');
            $.post('/ajax/remove_news',
                { 'id': id },
                function(result) {
                    if (result) {
                        $('.item-news-'+id+ '> .after_removing_background').show();

                        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                            .attr('data-notifyText',  'Ваша новость успешно удалена!')
                            .click();
                    }
                });
        });

        $('body').on( 'click' , '.ajax__undo_remove_news', function() {

            var id = $(this).attr('data-news-id');

            $.post('/ajax/undo_remove_news',
                {
                    'action'    : 'undo_remove_item',
                    'id'        : id,
                },
                function(result) {
                    if (result) {
                        $('.item-news-'+id+ '> .after_removing_background').hide();
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Успешно отменено')
                            .attr('data-notifyText',  'Выбранная вами новость успешно восстановлена!')
                            .click();
                    }
                });
        });

        /*
         *
         *
         *  Отправление комментариев для новостей
         *
         *
         */

        var ajax_send_news_comment = function( comment, news_id, user_id ) {

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
                var avatar      = $('.js-user-info').attr('data-avatar'),
                    user_name   = $('.js-user-info').attr('data-name');
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

        };

        $('body').on( 'click', '.ajax-news-leave-comment', function () {

            var comment     = $(this).closest('.reply__form-box').children('textarea').val(),
                news_id     = $(this).attr('data-news-id'),
                user_id     = $(this).attr('data-author-id');

            ajax_send_news_comment( comment, news_id, user_id );
            $(this).closest('.reply__form-box').children('textarea').val('');
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

        $('body').on( 'click', '.feedback__postlike', function(event) {
            var news_id     = $(this).attr('data-news-id'),
                user_id     = $(this).attr('data-user-id'),
                this_obj    = $(this);

            $.post('/ajax/news_likes',
                { 'news_id': news_id, 'author_id': user_id },
                function(result) {
                    var data = JSON.parse( result );
                    if( data == 'removed') {

                        var likeCount = parseInt(this_obj.find('.postlike__num').text(),10),
                            likeTotal = likeCount-1;
                        $('.feedback__postlike[data-news-id="'+ news_id +'"]').find('.fa').removeClass('fa-heart').addClass('fa-heart-o');
                        $('.feedback__postlike[data-news-id="'+ news_id +'"]').find('.postlike__num').text(likeTotal).css('color' , '#999');

                    } else if (data == 'added') {

                        var likeCount = parseInt(this_obj.find('.postlike__num').text(),10),
                            likeTotal = likeCount+1;

                        $('.feedback__postlike[data-news-id="'+ news_id +'"]').find('.fa').removeClass('fa-heart-o').addClass('fa-heart');
                        $('.feedback__postlike[data-news-id="'+ news_id +'"]').find('.postlike__num').text(likeTotal).css('color' , '#02abc0');

                    }
                }
            );
        });

    });
</script>
