<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.07.17
 * Time: 18:09
 */

?>

<script>

    var ajax_send_message = function() {

        if ( $('#dialog__send_message__submit').prop('disabled') == "disabled" )
            return false;

        var author      = $('#ajax-input-author').val(),
            chatroom    = $('#ajax-input-chatroom').val(),
            message     = $('#ajax-input-message').val(),
            images      = [];

        $( "#filelist_msg > li" ).each(function( index ) {
            images.push( $(this).find('img').attr('src') );
        });

        $.ajax({
            url:   '/ajax/send_message',
            data: {
                author      : author,
                chatroom    : chatroom,
                message     : message,
                images      : images
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function(xhr){
                if( images.length > 0 )
                {
                    $('.preloader').fadeIn();
                    $('.preloader__img').fadeIn();
                    $('body').delay(350).css({'overflow':'hidden'});
                }

                $('#ajax-input-message').prop('disabled', true);
                $('#dialog__send_message__submit').prop('disabled', true);
                $('#ajax-input-message').val('');
                $(".m-news-add-comment").css("opacity", "0.3");
            },
            success: function(result){

                if( result == 'XSSerror' ) {
                    $('#ajax-input-message').val( message );
                    $('.notify-trigger--alert').attr('data-notifyTitle', 'Сообщение не отправлено')
                        .attr('data-notifyText',  'В тексте сообщения обнаружены вредоносные ссылки!')
                        .click();
                }

                if (result) {
                    $("html, body").animate({ scrollTop: $(document).height() }, 100);
                    $('#filelist_msg').html('');
                    $('.attachment-count-list').hide();
                } else {

                }
            },
            error: function () {
                $('#ajax-input-message').val( message );
                $('.notify-trigger--alert').attr('data-notifyTitle', 'Сообщение не отправлено')
                    .attr('data-notifyText',  'В процессе отправления сообщения возникла ошибка!')
                    .click();
            },
            complete: function( result ){
                $('.preloader__img').fadeOut();
                $('.preloader').delay(350).fadeOut('slow');
                $('body').delay(350).css({'overflow':'visible'});
                $('#ajax-input-message').prop('disabled', false).focus();
                $('#dialog__send_message__submit').prop('disabled', false);
                $(".m-news-add-comment").css("opacity", "1");
            }
        });
    };

    $('.ajax-send-message').submit( function(event){
        event.preventDefault();
    });

    $('.reply-tbox__submit').click( function () {
        if( $('#ajax-input-message').val() || $('ul#filelist_msg li').size() >= 1 )
            ajax_send_message();
        else {
            $('.notify-trigger--alert').attr('data-notifyTitle', 'Сообщение не отправлено')
                .attr('data-notifyText',  'Вы не можете отправлять пустые сообщения!')
                .click();
        }
    });


    function insertTextAtCursor(el, text, offset) {
        var val = el.value, endIndex, range, doc = el.ownerDocument;
        if (typeof el.selectionStart == "number"
            && typeof el.selectionEnd == "number") {
            endIndex = el.selectionEnd;
            el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
            el.selectionStart = el.selectionEnd = endIndex + text.length+(offset?offset:0);
        } else if (doc.selection != "undefined" && doc.selection.createRange) {
            el.focus();
            range = doc.selection.createRange();
            range.collapse(false);
            range.text = text;
            range.select();
        }
    }

    $('#ajax-input-message').keypress(function(event) {

        if ( !event.ctrlKey && !event.altKey && !event.shiftKey && event.which == 13 ) {
            event.preventDefault();
            if( $('#ajax-input-message').val() || $('ul#filelist li').size() >= 1 )
                ajax_send_message();
            else {
                $('.notify-trigger--alert').attr('data-notifyTitle', 'Сообщение не отправлено')
                    .attr('data-notifyText',  'Вы не можете отправлять пустые сообщения!')
                    .click();
            }
        } else if ( ( event.ctrlKey || event.altKey || event.shiftKey ) && event.which == 13 ) {

            event.preventDefault();
            insertTextAtCursor ( document.getElementById('ajax-input-message'), '\n' );
        }

    });

</script>
