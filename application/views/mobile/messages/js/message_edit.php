<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.07.17
 * Time: 18:09
 */

?>

<script>

    $('body').on('click', '.ajax-edit-message', function () {

        message_id      = $(this).attr('data-message-id');
        chatroom_id     = $('#ajax__input__chatroom_id').val();

        $( "#filelist_msg_modal" ).html('');

        $.ajax({
            url:   '/ajax/get_message_item',
            data:{ 'message_id' : message_id },
            type: 'POST',
            dataType: 'json',
            beforeSend: function(xhr){
                $('.preloader').fadeIn();
                $('.preloader__img').fadeIn();
                $('body').delay(350).css({'overflow':'hidden'});
            },
            success: function(result){

                $.fancybox.close();
                var data  = result;

                $('#ajax__input__message_id').val( data.id );
                $('#ajax__input_edit_message_content').val( data.message_for_edit ).change();

                $('.reply-tbox__form-box').find('#filelist').attr('id', 'filelist_main');
                $('#edit-message').find('#filelist_modal').attr('id', 'filelist');

                $.each( data.images, function( key, value ) {
                    $('#filelist_msg_modal').append('<li class="js__existing_image"><img src="/uploads/messages/'+chatroom_id+'/small_'+value+'" data-original-src="'+value+'"><a href="#" class="remove js-remove_existing_image" data-image-original-name="images.jpeg"></a></li>');
                });

                $.fancybox.open({
                    'href' : '#edit-message',
                    'closeBtn' : false
                });

            },
            complete: function( result ){
                $('.preloader__img').fadeOut();
                $('.preloader').delay(350).fadeOut('slow');
                $('body').delay(350).css({'overflow':'visible'});
            }
        });

    });

    $('#ajax__submit__edit_message').click(function (event) {
        event.preventDefault();

        chatroom_id     = $('#ajax__input__chatroom_id').val();
        message_id      = $('#ajax__input__message_id').val();
        message         = $('#ajax__input_edit_message_content').val();
        post_images     = [];
        existing_images = [];

        $( "#filelist_msg_modal > li" ).each(function( index ) {
            if ( $(this).hasClass('js__existing_image') )
                existing_images.push( $(this).find('img').attr('data-original-src') );
            if ( !$(this).hasClass('js__existing_image') )
                post_images.push( $(this).find('img').attr('src') );
        });

        $.ajax({
            url:   '/ajax/edit_message',
            data: {
                chatroom_id         : chatroom_id,
                message_id          : message_id,
                message             : message,
                post_images         : post_images,
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
                if( result == 'XSSerror' ) {

                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Сообщение не изменено')
                        .attr('data-notifyText',  'В тексте сообщения обнаружены вредоносные ссылки!')
                        .click();

                }

                if (result) {
                    $.fancybox.close();
                    $('.notify-trigger--success').attr('data-notifyTitle', 'Готово')
                        .attr('data-notifyText',  'Ваше сообщение успешно изменено!')
                        .click();
                } else {
                    $.fancybox.close();
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                        .attr('data-notifyText',  'Сообщение прочитано и не может быть изменено!')
                        .click();
                }
            },
            complete: function( result ){
                $('.preloader__img').fadeOut();
                $('.preloader').delay(350).fadeOut('slow');
                $('body').delay(350).css({'overflow':'visible'});

                $( "#filelist_msg_modal" ).html('');
                $('#ajax__input__news_content').val('');
            }
        });

    });

</script>
