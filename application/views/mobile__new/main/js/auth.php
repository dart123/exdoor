<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 07.06.2018
 * Time: 0:26
 */

?>

<script>

    $(document).ready(function() {

        function timer() {
            count = count - 1;
            if (count <= 0) {
                clearInterval(counter);

                $('.js-ajax-change_password').hide();
                $('.js-ajax-change_password_link').show();

                $('.js-ajax-repeat-sms').hide();
                $('.js-ajax-repeat-sms_link').show();

                $('.js-auth-code-timer').html(count);
                $('.js-reg-code-timer').html(count);
                return;
            }
            $('.js-auth-code-timer').html(count);
            $('.js-reg-code-timer').html(count);
        }

        if ($('#login_unblock_time').length > 0) {
            $('.js-ajax-change_password').show();
            $('.js-ajax-change_password_link').hide();

            $('.js-ajax-repeat-sms').show();
            $('.js-ajax-repeat-sms_link').hide();

            var count = parseInt($('#login_unblock_time').val()) - parseInt($('#login_block_time').val());
            var counter = setInterval(timer, 1000); //1000 will  run it every 1 second
        }


        $('.js-authorization__button-modal').click(function (event) {
            event.preventDefault();
            var code, phone, phone_number, password;
            code    = $('.js-authorization__input-code').val();
            phone   = $('.js-authorization__input-phone').val();

            console.log( phone.length );

            phone_number = code + phone;
            password = $('.js-authorization__input-password').val();

            if( phone.length < 6 ) {

                $('.notify-trigger--alert').attr('data-notifyTitle', 'Ошибка')
                    .attr('data-notifyText',  'Введите номер телефона!')
                    .click();

                return false;
            }
            else {
                $.post('/ajax/enter',
                    {'action': 'ar', 'phone': phone_number, 'password': password, 'lang': page_lang },
                    function (result) {
                        if (result) {
                            var data = $.parseJSON(result);

                            if (data.code == 'auth_success' || data.code == 'confirm_success') {
                                document.location.href = "<?=$this->config->item('base_url');?>";
                            }
                            else if (data.code == 'auth_fail') {

                                $('.js-authorization__input-password').addClass('input__wrong_data');
                                $('.js-authorization__modal-title').html(data.title);
                                $('.js-authorization__modal-description').html(data.message);
                                $('.js-authorization__modal').modal();
                                $('.js-authorization__input-password').val('').focus();
                            }
                            else {
                                $('.js-authorization__modal-title').html(data.title);
                                $('.js-authorization__modal-description').html(data.message);
                                $('.js-authorization__modal').modal();
                                $('.js-authorization__input-password').val('').focus();
                            }

                        } else {
                            console.log('Возникла непредвиденная ошибка');
                        }
                    });
            }

        });


        // кликаем по кнопке, открывающей модалку, проверяем можно ли зарегистрировать номер?
        $('.js-authorization__modal-form').submit(function (event) {
            event.preventDefault();

            var code, phone, phone_number, password;
            code            = $('.js-authorization__input-code').val();
            phone           = $('.js-authorization__input-phone').val();
            phone_number    = code + phone;

            password        = $('.js-authorization__input-password').val();


            if( phone.length < 6 )
                return 0;
            else {
                $.post('/ajax/enter',
                    {'action': 'ar', 'phone': phone_number, 'password': password, 'lang': page_lang },
                    function (result) {
                        if (result) {

                            var data = $.parseJSON(result);

                            if (data.code == 'auth_success' || data.code == 'confirm_success') {
                                document.location.href = "<?=$this->config->item('base_url');?>";
                            }
                            else if (data.code == 'auth_fail') {

                                $('.js-authorization__input-password').addClass('input__wrong_data');
                                $('.js-authorization__modal-title').html(data.title);
                                $('.js-authorization__modal-description').html(data.message);
                                $('.js-authorization__modal').modal();
                                $('.js-authorization__input-password').val('').focus();
                            }
                            else {
                                $('.js-authorization__modal-title').html(data.title);
                                $('.js-authorization__modal-description').html(data.message);
                                $('.js-authorization__modal').modal();
                                $('.js-authorization__input-password').val('').focus();
                            }

                        } else {
                            console.log('Возникла непредвиденная ошибка');
                        }
                    });
            }

        });


        $('.js-ajax-change_password_link > a').click(function (event) {
            event.preventDefault();
            var code, phone, phone_number, password;
            code = $('#selected-head').val();
            phone = $('#selected-head-number').val();
            phone_number = code + phone;


            $.post('/ajax/change_password',
                {'action': 'change_password', 'phone': phone_number, 'process': 'auth', 'lang': page_lang },
                function (result) {
                    if (result) {

                        var data = $.parseJSON(result);

                        function timer() {
                            count = count - 1;
                            if (count <= 0) {
                                clearInterval(counter);

                                $('.js-ajax-change_password').hide();
                                $('.js-ajax-change_password_link').show();

                                $('.js-auth-code-timer').html(count);
                                return;
                            }
                            $('.js-auth-code-timer').html(count);
                        }

                        var count = 40;
                        var counter = setInterval(timer, 1000); //1000 will  run it every 1 second

                        $('.js-modal-auth-description > h2').html(data.title);
                        $('.js-modal-auth-description > p').html(data.message);

                        $('.js-ajax-change_password').show();
                        $('.js-ajax-change_password_link').hide();
                    }
                });
        });


        $('.js-ajax-repeat-sms_link > a').click(function (event) {
            event.preventDefault();

            var code, phone, phone_number, password;
            code = $('#selected-01').val();
            phone = $('#phone-number-middle').val();
            phone_number = code + phone;

            $.post('/ajax/change_password',
                {'action': 'change_password', 'phone': phone_number, 'process': 'reg', 'lang': page_lang },
                function (result) {
                    if (result) {

                        var data = $.parseJSON(result);

                        function timer() {
                            count = count - 1;
                            if (count <= 0) {
                                clearInterval(counter);

                                $('.js-ajax-repeat-sms').hide();
                                $('.js-ajax-repeat-sms_link').show();

                                $('.js-reg-code-timer').html(count);
                                return;
                            }
                            $('.js-reg-code-timer').html(count);
                        }

                        var count = 40;
                        var counter = setInterval(timer, 1000); //1000 will  run it every 1 second

                        $('.js-modal-reg-description > h2').html(data.title);
                        $('.js-modal-reg-description > p').html(data.message);

                        $('.js-ajax-repeat-sms').show();
                        $('.js-ajax-repeat-sms_link').hide();
                    }
                });
        });
    });
</script>
