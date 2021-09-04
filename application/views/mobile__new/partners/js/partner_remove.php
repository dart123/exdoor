<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.07.17
 * Time: 21:07
 *
 *      Пользователь убирает из своих партнеров другого пользователя
 */
?>

<script>

    $('body').on('click', '.js-partner__open_modal', function () {

        $('.js-partner__remove__modal').removeClass('is-hidden');


        $.fancybox.open( $(".js-partner__remove__modal") );


    });


    $('body').on('click', '.js-partner__remove_user', function(){
        var obj_this        = $(this),
            user_id         = $(this).attr('data-user-id'),
            partner_id      = $(this).attr('data-partner-id');

        $.post('/ajax/partners__remove_user',
            { 'user_id':user_id, 'partner_id':partner_id },
            function(result) {
                var data  = $.parseJSON(result);
                if (data) {
                    $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                        .attr('data-notifyText',  'Пользователь успешно удален из списка партнеров')
                        .click();

                    $('.js-partner__remove__modal').addClass('is-hidden');
                    $('.js-partner__open_modal').addClass('is-hidden');

                    $('.js-partner__undo_remove_user').removeClass('is-hidden');

                }
            }
        );

        $.fancybox.close();
    });

    $('body').on('click', '.js-partner__undo_remove_user', function () {

        var obj_this        = $(this),
            user_id         = $(this).attr('data-user-id'),
            partner_id      = $(this).attr('data-partner-id');

        $.post('/ajax/partners__undo_remove_user',
            { 'user_id':user_id, 'partner_id':partner_id },
            function(result) {
                var data  = $.parseJSON(result);
                if (data) {
                    $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                        .attr('data-notifyText',  'Действие отменено')
                        .click();

                    $('.js-partner__open_modal').removeClass('is-hidden');
                    $('.js-partner__undo_remove_user').addClass('is-hidden');
                }
            }
        );
        $.fancybox.close();
    });
</script>
