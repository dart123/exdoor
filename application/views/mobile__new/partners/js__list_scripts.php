<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 23.01.17
 * Time: 22:55
 */
?>

<script>
    $(document).ready( function () {




        $('body').on('click', '.js-partner__remove_user', function(){
            var obj_this        = $(this),
                user_id         = $(this).attr('data-user-id'),
                partner_id      = $(this).attr('data-partner-id'),
                action_undo     = 0;

            if( obj_this.hasClass('js-partner__action_undo') ) {
                action_undo = 1;
            }

            $.post('/ajax/partners__remove_user',
                { 'user_id':user_id, 'partner_id':partner_id, 'undo': action_undo },
                function(result) {
                    var data  = $.parseJSON(result);
                    if (data) {
                        $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                            .attr('data-notifyText',  'Пользователь успешно удален из списка партнеров')
                            .click();

                        obj_this.closest('.partner-status__list').find('.js-partner__remove_user').addClass('is-hidden');
                        obj_this.closest('.partner-status__list').find('.js-partner__undo_remove_user').removeClass('is-hidden');
                    }
                }
            );
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

                        obj_this.closest('.partner-status__list').find('.js-partner__remove_user').removeClass('is-hidden');
                        obj_this.closest('.partner-status__list').find('.js-partner__undo_remove_user').addClass('is-hidden');
                    }
                }
            );
        });


        /*
         Партнеры - Входящие заявки
         */



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
                        if(action_undo == 1) {
                            $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                                .attr('data-notifyText',  'Добавление пользователя в партнеры отменено')
                                .click();

                            obj_this.removeClass('js-partner__action_undo');
                            obj_this.find('i').removeClass('fa-undo').addClass('fa-check');
                            obj_this.find('span').text('Принять');
                        }
                        else
                        {
                            $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                                .attr('data-notifyText',  'Пользователь успешно добавлен в список партнеров')
                                .click();

                            obj_this.addClass('js-partner__action_undo');
                            obj_this.find('i').removeClass('fa-check').addClass('fa-undo');
                            obj_this.find('span').text('Вернуть');
                        }

                    } else if (data == 'false') {
                        $('.notify-trigger--alert').attr('data-notifyTitle', "Ошибка!")
                            .attr('data-notifyText',  'Похоже, что данная зявка уже не актуальна')
                            .click();

                        $('.js__list__partner[data-partner-id="'+partner_id+'"]').fadeOut(300);
                    }
                });
        });


        // По кресту во входящих

        $('body').on('click', '.js-partner__cancel_request_inbox', function(){
            var obj_this        = $(this),
                new_object      = obj_this.closest('.partner-status__list').find('.js-partner__add_user'),
                user_id         = $(this).attr('data-user-id'),
                partner_id      = $(this).attr('data-partner-id'),
                action_undo     = 0;

            if( obj_this.find('i').hasClass( 'fa-undo' ) )
                action_undo     = 1;

            $.post('/ajax/partners__cancel_request',
                { 'user_id':user_id, 'partner_id':partner_id, 'undo':action_undo },
                function(result) {
                    var data  = $.parseJSON(result);
                    if (data) {

                        console.log( data );
                        if( action_undo == 1 ) {
                            $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                                .attr('data-notifyText',  'Заявка восстановлена!')
                                .click();

                            obj_this.find('i').removeClass('fa-undo').addClass('fa-times');
                            new_object.removeClass('is-hidden');
                        } else {
                            $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                                .attr('data-notifyText',  'Заявка отменена')
                                .click();

                            obj_this.find('i').removeClass('fa-times').addClass('fa-undo');
                            new_object.addClass('is-hidden');
                        }




                        /*
                        new_object.removeClass('js-partner__add_user').addClass('js-partner__send_request js-partner__send_request_inbox').find('span').text('Отправить заявку');
                        new_object.find('i').removeClass('fa-check').addClass('fa-plus');

                        obj_this.addClass('is-hidden');
                        */

                    }
                });
        });

        /*
         Партнеры - Исходящие заявки
         */


        $('body').on('click', '.js-partner__cancel_request', function(){
            var obj_this        = $(this),
                user_id         = $(this).attr('data-user-id'),
                partner_id      = $(this).attr('data-partner-id');

            $.post('/ajax/partners__cancel_request',
                { 'user_id':user_id, 'partner_id':partner_id },
                function(result) {
                    var data  = $.parseJSON(result);
                    if (data) {
                        $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                            .attr('data-notifyText',  'Заявка отменена')
                            .click();


                        obj_this.closest('.partner-status__list').find('.add-partner').removeClass('is-hidden');
                        obj_this.closest('.partner-status__list').find('.del-partner').addClass('is-hidden');

                    }
                });
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

                        if( obj_this.hasClass('js-partner__send_request_inbox')) {
                            document.location.href = <?=$this->config->item('base_url');?>'/partners/outbox';
                        } else {
                            $('.notify-trigger--success').attr('data-notifyTitle', "Готово!")
                                .attr('data-notifyText',  'Ваша заявка на добавление в список партнеров отправлена')
                                .click();
                            obj_this.closest('.partner-status__list').find('.del-partner').removeClass('is-hidden');
                            obj_this.closest('.partner-status__list').find('.add-partner').addClass('is-hidden');
                        }

                    }
                });
        });

    })
</script>
