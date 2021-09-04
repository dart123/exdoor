<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 01.07.17
 * Time: 0:15
 */

if( isset( $page_content["company_news"] ) && $page_content["company_news"] === true )
    $is_company_news    = true;
else
    $is_company_news    = false;

?>
<script>
    $('.fancybox__add_news').click( function() {

        $('#filelist_news').html('');
        $('#ajax__input__news_content').val('');

        $('#add-news').find('.modal__title').text('Добавить новость');
        $('#ajax__input__news_id').val( '' );
        $("#ajax__input__action").val( 'add_news' );
        $('#add-news').find(".add-news__submit").val("Опубликовать");

        $.fancybox.open({
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

        if( content.length == 0 ) {
            $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                .attr('data-notifyText',  'Ваша новость не может быть без текста!')
                .click();

            $("#ajax__input__news_content").addClass('input__wrong_data').focus();
            return;
        }

        if( action == "add_news" )
        {
            $.ajax({
                url:   '/ajax/add_news',
                data: {
                    author_id           : author_id,
                    content             : content,
                    <?php if ( $is_company_news ):?>
                    company_news        : 1,
                    <?php endif;?>
                    images              : images
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                    $('body').delay(350).css({'overflow':'hidden'});
                },
                success: function(result){
                    if (result) {
                        $.fancybox.close();
                        var data  = result;
                        if( typeof data != 'object' && data == "XSSerror") {
                            $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                                .attr('data-notifyText',  'В вашей новости обнаружен вредоносный код!')
                                .click();
                        }
                        else {
                            $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                                .attr('data-notifyText',  'Ваша новость успешно добавлена!')
                                .click();
                        }

                    }
                },
                complete: function( result ){
                    $('.preloader__img').fadeOut();
                    $('.preloader').delay(350).fadeOut('slow');
                    $('body').delay(350).css({'overflow':'visible'});
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
                    <?php if ( $is_company_news ):?>
                    company_news        : 1,
                    <?php endif;?>
                    post_images         : images,
                    existing_images     : existing_images
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function(xhr){
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                    $('body').delay(350).css({'overflow':'hidden'});
                },
                success: function(result){
                    if ( typeof result == 'object' ) {
                        $.fancybox.close();
                        var data            = result,
                            template        = $('#mustache__news_loop').html(),
                            output          = Mustache.render(template, data);

                        $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                            .attr('data-notifyText',  'Ваша новость успешно изменена!')
                            .click();

                        $("#js__news_list__news_"+news_id).replaceWith( output );

                        reinitializeMasonry();
                    } else if ( result == 'no_permissions' ) {
                        $.fancybox.close();
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'Похоже что у Вас нет прав на изменение этой новости!')
                            .click();
                    } else if( result == "XSSerror" ) {
                        $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                            .attr('data-notifyText',  'В вашей новости обнаружен вредоносный код!')
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

        }


    });
</script>
