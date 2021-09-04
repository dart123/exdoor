<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 12.07.17
 * Time: 18:09
 */

?>

<script>

    $('body').on( 'click', '.ajax-remove-message', function () {

        message_id  = $(this).attr('data-message-id');
        chatroom_id = $(this).attr('data-chatroom-id');

        $.post('/ajax/remove_message',
            { 'message_id':message_id, 'chatroom_id': chatroom_id },
            function(result) {

                data    = JSON.parse( result );

                if (data == 'removed') {
                    $('.message-id-'+message_id+' .conversation__action > a').css({'opacity': 0});
                    $('.message-id-'+message_id+' .conversation__author').css({'opacity': .3});
                    $('.message-id-'+message_id+' .conversation__date').css({'opacity': .3});
                    $('.message-id-'+message_id+' .conversation__body > .conversation__author-name').hide();
                    $('.message-id-'+message_id+' .conversation__body > .conversation__text').hide();
                    $('.message-id-'+message_id+' .conversation__body > .conversation__images').hide();
                    $('.message-id-'+message_id+' .conversation__body > .ajax__restore_message').show();
                }

                if(data == 'deleted') {
                    $('.message-id-'+message_id).fadeOut(300);
                }
            });
    });

    $('body').on( 'click', '.ajax__restore_message', function () {

        message_id  = $(this).attr('data-message-id');
        chatroom_id = $(this).attr('data-chatroom-id');

        $.post('/ajax/restore_message',
            { 'message_id':message_id, 'chatroom_id': chatroom_id },
            function(result) {
                if (result) {

                    $('.message-id-'+message_id+' .conversation__action > a').css({'opacity': 1});
                    $('.message-id-'+message_id+' .conversation__author').css({'opacity': 1});
                    $('.message-id-'+message_id+' .conversation__date').css({'opacity': 1});
                    $('.message-id-'+message_id+' .conversation__body > .conversation__author-name').show();
                    $('.message-id-'+message_id+' .conversation__body > .conversation__text').show();
                    $('.message-id-'+message_id+' .conversation__body > .conversation__images').show();
                    $('.message-id-'+message_id+' .conversation__body > .ajax__restore_message').hide();

                }
            });
    });

</script>
