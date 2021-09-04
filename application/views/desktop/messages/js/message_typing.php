<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.07.17
 * Time: 18:12
 */
?>

<script>

    $(document).ready( function () {



        var timerId;
        var typing = false;

        $('#ajax-input-message').bind('input',function(e){

            var author      = $('#ajax-input-author').val();
            var chatroom    = $('#ajax-input-chatroom').val();

            if( typing == false ) {
                $.post('/ajax/message_typing', { 'author':author, 'chatroom': chatroom, 'action': 'start' });
                typing = true;
            }

            clearTimeout(timerId);
            timerId = setTimeout(function() {
                    $.post('/ajax/message_typing', { 'author':author, 'chatroom': chatroom, 'action': 'stop' });
                    typing = false;
                },
                5000);
        });

    });


</script>
