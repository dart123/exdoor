/**
 * Created by developer on 05.07.16.
 */




$(document).ready(function() {

    $( "#filelist" ).sortable({
        helper: 'clone',
        appendTo: '.filelist__clone'
    });
    $( "#existing_images" ).sortable({
        helper: 'clone',
        appendTo: '.filelist__clone'
    });


    function timer()  {
        count=count-1;
        if (count <= 0) {
            clearInterval(counter);

            $('.js-ajax-change_password').hide();
            $('.js-ajax-change_password_link').show();

            $('.js-ajax-repeat-sms').hide();
            $('.js-ajax-repeat-sms_link').show();

            $('.js-auth-code-timer').html( count );
            $('.js-reg-code-timer').html( count );
            return;
        }
        $('.js-auth-code-timer').html(count);
        $('.js-reg-code-timer').html( count );
    }

    if( $('#login_unblock_time').length > 0 ) {
        $('.js-ajax-change_password').show();
        $('.js-ajax-change_password_link').hide();

        $('.js-ajax-repeat-sms').show();
        $('.js-ajax-repeat-sms_link').hide();

        var count   = parseInt( $('#login_unblock_time').val() ) - parseInt( $('#login_block_time').val() );
        var counter = setInterval(timer, 1000); //1000 will  run it every 1 second
    }


    $('.js-header-auth').submit(function(event){
        event.preventDefault();

        $('#js-ajax__auth-password').show();
        $('.js-ajax__auth').show();
        $('.js-ajax-change_password_link').show();

        var code, phone, phone_number, password;
        code            = $('#selected-head').val();
        phone           = $('#selected-head-number').val();
        phone_number    = code + phone;
        password        = $('#js-ajax__auth-password').val();

        $.post('/ajax/enter',
            { 'action': 'ar', 'phone':phone_number, 'password':password, 'lang': page_lang },
            function(result) {
                if (result) {
                    var data  = $.parseJSON(result);

                    if( data.code == 'auth_success' || data.code == 'confirm_success' ){
                        document.location.href = 'https://exdor.ru/';
                    }
                    else if( data.code == 'auth_fail') {
                        $('#js-ajax__auth-password').addClass('input__wrong_data');
                        $('.js-modal-auth-title').html(data.title);
                        $('.js-modal-auth-description > h2').html(data.title);
                        $('.js-modal-auth-description > p').html(data.message);
                        $('.modal__auth').click();
                        $('#js-ajax__auth-password').val('').focus();
                    }
                    else if( data.code == 'auth_user_inactive') {
                        $('#js-ajax__auth-password').hide();
                        $('.send-code__submit').hide();
                        $('.js-ajax-change_password_link').hide();
                        $('.js-modal-auth-title').html(data.title);
                        $('.js-modal-auth-description > h2').html(data.title);
                        $('.js-modal-auth-description > p').html(data.message);
                        $('.modal__auth').click();
                        $('#js-ajax__auth-password').val('');
                    }
                    else {
                        $('.js-modal-auth-title').html(data.title);
                        $('.js-modal-auth-description > h2').html(data.title);
                        $('.js-modal-auth-description > p').html(data.message);
                        $('.modal__auth').click();
                        $('#js-ajax__auth-password').val('').focus();
                    }

                } else {
                    console.log('Возникла непредвиденная ошибка');
                }
            });
    });


    // кликаем по кнопке, открывающей модалку, проверяем можно ли зарегистрировать номер?
    $('.body_reg_form').submit(function(event){
        event.preventDefault();

        $('#js-ajax__auth-password').show();
        $('.js-ajax__auth').show();
        $('.js-ajax-change_password_link').show();



        var code, phone, phone_number, password;
        code            = $('#selected-01').val();
        phone           = $('#phone-number-middle').val();
        phone_number    = code + phone;

        password = $('.js-ajax__reg-password').val();
        $.post('/ajax/enter',
            { 'action': 'ar', 'phone':phone_number, 'password':password, 'lang': page_lang },
            function(result) {
                if (result) {

                    var data  = $.parseJSON(result);

                    if( data.code == 'auth_success' || data.code == 'confirm_success' ){
                        document.location.href = 'https://exdor.ru/';
                    }
                    else if( data.code == 'auth_fail') {

                        $('.js-ajax__reg-password').addClass('input__wrong_data');
                        $('.js-modal-reg-title').html(data.title);
                        $('.js-modal-reg-description > h2').html(data.title);
                        $('.js-modal-reg-description > p').html(data.message);
                        $('.modal__reg').click();
                        $('.js-ajax__reg-password').val('').focus();
                    }
                    else if( data.code == 'auth_user_inactive') {
                        $('#js-ajax__auth-password').hide();
                        $('.send-code__submit').hide();
                        $('.js-ajax-change_password_link').hide();
                        $('.js-modal-auth-title').html(data.title);
                        $('.js-modal-auth-description > h2').html(data.title);
                        $('.js-modal-auth-description > p').html(data.message);
                        $('.modal__auth').click();
                        $('#js-ajax__auth-password').val('');
                    }
                    else {
                        $('.js-modal-reg-title').html(data.title);
                        $('.js-modal-reg-description > h2').html(data.title);
                        $('.js-modal-reg-description > p').html(data.message);
                        $('.modal__reg').click();
                        $('.js-ajax__reg-password').val('').focus();
                    }

                } else {
                    console.log('Возникла непредвиденная ошибка');
                }
            });
    });


    $('.js-ajax-change_password_link > a').click(function(event){
        event.preventDefault();
        var code, phone, phone_number, password;
        code            = $('#selected-head').val();
        phone           = $('#selected-head-number').val();
        phone_number    = code + phone;


        $.post('/ajax/change_password',
            { 'action': 'change_password', 'phone':phone_number, 'process': 'auth', 'lang': page_lang },
            function(result) {
                if (result) {

                    var data  = $.parseJSON(result);

                    function timer()  {
                        count=count-1;
                        if (count <= 0) {
                            clearInterval(counter);

                            $('.js-ajax-change_password').hide();
                            $('.js-ajax-change_password_link').show();

                            $('.js-auth-code-timer').html( count );
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


    $('.js-ajax-repeat-sms_link > a').click(function(event){
        event.preventDefault();

        var code, phone, phone_number, password;
        code            = $('#selected-01').val();
        phone           = $('#phone-number-middle').val();
        phone_number    = code + phone;

        $.post('/ajax/change_password',
            { 'action': 'change_password', 'phone':phone_number, 'process': 'reg', 'lang': page_lang },
            function(result) {
                if (result) {

                    var data  = $.parseJSON(result);

                    function timer()  {
                        count=count-1;
                        if (count <= 0) {
                            clearInterval(counter);

                            $('.js-ajax-repeat-sms').hide();
                            $('.js-ajax-repeat-sms_link').show();

                            $('.js-reg-code-timer').html( count );
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


























    /*
        Сообщения создание нового диалога
     */



/*
    $('body').on('keydown','.conversation__text', function(event) {
        if ( $(this).attr('contenteditable') == 'true' && event.which == 13) {
            var id = $(this).attr('data-message-id');
            event.preventDefault();

            $(this).attr('contenteditable','false');

            var message = $('.message-id-' + id ).find('.conversation__text').text();

            $.post('/ajax/edit_message',
                { 'message_id':id, 'message': message },
                function(result) {
                    if (result) {
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Сообщение отредатировано')
                            .attr('data-notifyText',  'все отлично')
                            .click();
                    } else {
                        $('.notify-trigger--success').attr('data-notifyTitle', 'Сообщение не отредактировано')
                            .attr('data-notifyText',  'Возникла ошибка!')
                            .click();
                    }
                }
            );
        }
    });

*/









});