<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 02.07.17
 * Time: 21:11
 *
 *      Пользователь принимает в друзья партнера, который отправил заявку
 */
?>


<script>

    $('body').on('click', '.js-partner__add_user', function(){
        var obj_this        = $(this),
            user_id         = $(this).attr('data-user-id'),
            partner_id      = $(this).attr('data-partner-id'),
            action_undo     = 0;

        if( obj_this.hasClass('js-partner__action_undo') ) {
            action_undo = 1;
        }
        $.post('/ajax/partners__add_user',
            { 'user_id':user_id, 'partner_id':partner_id, 'undo': action_undo },
            function(result) {
                var data  = $.parseJSON(result);
                if (data == 'true' ) {
                    if( action_undo == 1 ){
                        $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                            .attr('data-notifyText',  'Действие успешно отменено')
                            .click();

                        obj_this.removeClass('js-partner__action_undo');
                        obj_this.find('i').removeClass('fa-undo').addClass('fa-plus-circle');
                        obj_this.find('span').text('Принять в партнеры');
                    } else {
                        $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                            .attr('data-notifyText',  'Пользователь успешно добавлен в список партнеров')
                            .click();

                        obj_this.addClass('js-partner__action_undo');
                        obj_this.find('i').removeClass('fa-plus-circle').addClass('fa-undo');
                        obj_this.find('span').text('Отменить добавление в партнеры');
                    }
                } else if (data == 'false') {
                    $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                        .attr('data-notifyText',  'Похоже, что данная зявка уже не актуальна')
                        .click();

                    $('.js__list__partner[data-partner-id="'+partner_id+'"]').fadeOut(300);
                }
            });
    });

</script>
