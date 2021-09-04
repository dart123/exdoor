<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.07.17
 * Time: 21:19

 *          Временное решение для сообщений

 */


?>
<script>

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



    var ajax_send_message = function() {

        var user_id     = <?php echo $this->session->user;?>,
            partner     = <?php echo $page_content["partner"]->id;?>,
            message     = $('#ajax-input-message').val();

        $.ajax({
            url:   '/ajax/partners__request__add_message',
            data: {
                user_id     : user_id,
                partner_id  : partner,
                message     : message
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function(xhr){
                $('#ajax-input-message').prop('disabled', true);
                $('#dialog__send_message__submit').prop('disabled', true);
            },
            success: function(result){
                if (result) {
                    $('#ajax-input-message').val('');
                    $('.modal__partner__cancel_request').addClass('is-hidden');
                    $('.notify-trigger--success').attr('data-notifyTitle', 'Сообщение отправлено!')
                        .attr('data-notifyText',  'Вы можете продолжить переписку в разделе Сообщения!')
                        .click();
                }
            },
            error: function ( result ) {
                $('.notify-trigger--alert').attr('data-notifyTitle', 'Сообщение не отправлено')
                    .attr('data-notifyText',  'В процессе отправления сообщения возникла ошибка!')
                    .click();
            },
            complete: function( result ){
                $('#ajax-input-message').prop('disabled', false);
                $('#dialog__send_message__submit').prop('disabled', false);
            }
        });
    };


    $('.reply-tbox__submit').click( function () {
        if( $('#ajax-input-message').val() ){
            ajax_send_message();
        }
        else {
            $('.notify-trigger--alert').attr('data-notifyTitle', 'Сообщение не отправлено')
                .attr('data-notifyText',  'Вы не можете отправлять пустые сообщения!')
                .click();
        }
    });


    $('#ajax-input-message').keypress(function(event) {

        if ( !event.ctrlKey && !event.altKey && !event.shiftKey && event.which == 13 ) {
            event.preventDefault();
            if( $('#ajax-input-message').val() ) {
                ajax_send_message();
            }
        } else if ( ( event.ctrlKey || event.altKey || event.shiftKey ) && event.which == 13 ) {
            event.preventDefault();
            insertTextAtCursor ( document.getElementById('ajax-input-message'), '\n' );
        }

    });
</script>
