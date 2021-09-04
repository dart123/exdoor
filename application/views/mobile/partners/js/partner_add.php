<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.07.17
 * Time: 21:05
 *
 *      Пользователь добавляет в друзья партнера
 */
?>

<script>

    $('body').on('click', '.js-partner__modal__cancel_request', function () {
        $('.modal__partner__cancel_request').removeClass('is-hidden');
        $.fancybox.open( $('.modal__partner__cancel_request') );

    });


    $('body').on('click', '.js-partner__send_request', function(){

        var obj_this        = $(this),
            user_id         = $(this).attr('data-user-id'),
            partner_id      = $(this).attr('data-partner-id');

        $.post('/ajax/partners__send_request',
            { 'user_id':user_id, 'partner_id':partner_id },
            function(result) {
                var data  = $.parseJSON(result);
                if (data) {
                    $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                        .attr('data-notifyText',  'Ваша заявка на добавление в список партнеров отправлена')
                        .click();

                    $('.relationship__none').addClass('is-hidden');
                    $('.relationship__get_request').removeClass('is-hidden');
                    $('.modal__partner__cancel_request').removeClass('is-hidden');

                    $.fancybox.open( $('.modal__partner__cancel_request') );



                }
            });
    });



</script>
