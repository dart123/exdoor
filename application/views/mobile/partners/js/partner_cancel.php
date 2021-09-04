<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.07.17
 * Time: 21:11
 *
 *      Пользователь сам отменяет только что отправленный запрос
 */
?>

<script>
    $('body').on('click', '.js-partner__cancel_request', function(){
        var obj_this        = $(this),
            user_id         = $(this).attr('data-user-id'),
            partner_id      = $(this).attr('data-partner-id');

        $('.modal__partner__cancel_request').removeClass('is-hidden');

        $.post('/ajax/partners__cancel_request',
            { 'user_id':user_id, 'partner_id':partner_id },
            function(result) {
                var data  = $.parseJSON(result);
                if (data) {
                    $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                        .attr('data-notifyText',  'Ваш запрос на добавление в партнеры отменен')
                        .click();
                    $('.relationship__get_request').addClass('is-hidden');
                    $('.relationship__none').removeClass('is-hidden');
                }
            });

        $.fancybox.close();
    });
</script>
